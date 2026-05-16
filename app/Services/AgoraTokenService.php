<?php

namespace App\Services;

class AgoraTokenService
{
    public const ROLE_HOST = 1;

    public const ROLE_AUDIENCE = 2;

    public function generateToken(string $channelName, int|string $uid, int $role): string
    {
        $appId = config('services.agora.app_id');
        $appCertificate = config('services.agora.app_certificate');

        if (empty($appId) || empty($appCertificate)) {
            throw new \RuntimeException('Agora credentials are not configured.');
        }

        $token = AgoraAccessToken::init($appId, $appCertificate, $channelName, (int) $uid);

        if ($token === null) {
            throw new \RuntimeException('Unable to initialize Agora access token.');
        }

        $expireTimestamp = time() + 3600;
        $privileges = AgoraAccessToken::Privileges;

        $token->addPrivilege($privileges['kJoinChannel'], $expireTimestamp);

        if ($role === self::ROLE_HOST) {
            $token->addPrivilege($privileges['kPublishAudioStream'], $expireTimestamp);
            $token->addPrivilege($privileges['kPublishVideoStream'], $expireTimestamp);
            $token->addPrivilege($privileges['kPublishDataStream'], $expireTimestamp);
        }

        return $token->build();
    }
}

class AgoraMessage
{
    public int $salt;

    public int $ts;

    /** @var array<int, int> */
    public array $privileges = [];

    public function __construct()
    {
        $this->salt = random_int(1, 100000);
        $this->ts = time() + 3600;
    }

    /** @return list<int> */
    public function packContent(): array
    {
        $buffer = unpack('C*', pack('V', $this->salt));
        $buffer = array_merge($buffer, unpack('C*', pack('V', $this->ts)));
        $buffer = array_merge($buffer, unpack('C*', pack('v', count($this->privileges))));

        foreach ($this->privileges as $key => $value) {
            $buffer = array_merge($buffer, unpack('C*', pack('v', $key)));
            $buffer = array_merge($buffer, unpack('C*', pack('V', $value)));
        }

        return $buffer;
    }
}

class AgoraAccessToken
{
    public const Privileges = [
        'kJoinChannel' => 1,
        'kPublishAudioStream' => 2,
        'kPublishVideoStream' => 3,
        'kPublishDataStream' => 4,
    ];

    public string $appID;

    public string $appCertificate;

    public string $channelName;

    public string $uid;

    public AgoraMessage $message;

    public static function init(string $appID, string $appCertificate, string $channelName, int $uid): ?self
    {
        if ($appID === '' || $appCertificate === '' || $channelName === '') {
            return null;
        }

        $accessToken = new self;
        $accessToken->appID = $appID;
        $accessToken->appCertificate = $appCertificate;
        $accessToken->channelName = $channelName;
        $accessToken->uid = $uid === 0 ? '' : (string) $uid;
        $accessToken->message = new AgoraMessage;

        return $accessToken;
    }

    public function addPrivilege(int $key, int $expireTimestamp): self
    {
        $this->message->privileges[$key] = $expireTimestamp;

        return $this;
    }

    public function build(): string
    {
        $msg = $this->message->packContent();
        $val = array_merge(
            unpack('C*', $this->appID),
            unpack('C*', $this->channelName),
            unpack('C*', $this->uid),
            $msg
        );

        $sig = hash_hmac('sha256', implode(array_map('chr', $val)), $this->appCertificate, true);
        $crcChannelName = crc32($this->channelName) & 0xffffffff;
        $crcUid = crc32($this->uid) & 0xffffffff;

        $content = array_merge(
            unpack('C*', agora_pack_string($sig)),
            unpack('C*', pack('V', $crcChannelName)),
            unpack('C*', pack('V', $crcUid)),
            unpack('C*', pack('v', count($msg))),
            $msg
        );

        return '006' . $this->appID . base64_encode(implode(array_map('chr', $content)));
    }
}

function agora_pack_string(string $value): string
{
    return pack('v', strlen($value)) . $value;
}
