<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Group Enrollment</title>
    <style>
:root{--gold:#C9A84C;--gold-light:#E8C97A;--gold-dim:#7a6230;--black:#0d0d0d;--card:#161616;--border:rgba(201,168,76,0.18);--border-h:rgba(201,168,76,0.5);--text:#D8D0C0;--muted:#7a7060;--red:#C0392B}
*{box-sizing:border-box;margin:0;padding:0}
body{background:var(--black);color:var(--text);font-family:Georgia,serif;font-size:14px}
@import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Crimson+Pro:ital,wght@0,300;0,400;1,300&display=swap');
.wrap{padding:28px 20px 40px;background:var(--black);min-height:100vh}
.hd{text-align:center;margin-bottom:24px;animation:fd .8s ease both}
.tag{display:inline-block;font-family:Cinzel,serif;font-size:9px;letter-spacing:.22em;color:var(--gold);border:1px solid var(--border);padding:4px 14px;margin-bottom:10px}
.hd h1{font-family:Cinzel,serif;font-size:clamp(1.4rem,4vw,2.2rem);color:#fff;margin-bottom:8px}
.hd h1 em{color:var(--gold);font-style:normal;display:inline-block;border-bottom:1px solid var(--gold);padding-bottom:2px}
.prices{display:flex;align-items:center;justify-content:center;gap:12px;font-family:Cinzel,serif}
.old{font-size:1.1rem;color:var(--muted);text-decoration:line-through;text-decoration-color:var(--red)}
.new{font-size:1.6rem;color:var(--gold-light);font-weight:700}
.div{display:flex;align-items:center;gap:10px;margin:20px 0}
.div span{flex:1;height:1px;background:linear-gradient(90deg,transparent,var(--gold-dim))}
.div span:last-child{background:linear-gradient(270deg,transparent,var(--gold-dim))}
.grid{display:grid;grid-template-columns:1fr 1fr;gap:20px;animation:fu .7s .2s ease both}
@media(max-width:600px){.grid{grid-template-columns:1fr}}
.panel{background:var(--card);border:1px solid var(--border);padding:24px;position:relative;transition:border-color .3s}
.panel:hover{border-color:var(--border-h)}
.panel::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--gold),transparent);opacity:0;transition:opacity .3s}
.panel:hover::before{opacity:1}
.ptitle{font-family:Cinzel,serif;font-size:8px;letter-spacing:.22em;text-transform:uppercase;color:var(--gold);margin-bottom:18px;display:flex;align-items:center;gap:8px}
.ptitle::after{content:'';flex:1;height:1px;background:var(--border)}
.bb{background:rgba(201,168,76,.04);border:1px solid var(--border);border-left:3px solid var(--gold);padding:14px 16px;margin-bottom:12px;transition:background .3s}
.bb:hover{background:rgba(201,168,76,.09)}
.bname{font-family:Cinzel,serif;font-size:8px;letter-spacing:.14em;color:var(--gold);margin-bottom:7px;text-transform:uppercase}
.br{display:flex;gap:8px;margin-bottom:4px;font-size:.78rem}
.br .lb{color:var(--muted);min-width:52px;font-style:italic}
.notice{background:rgba(192,57,43,.08);border:1px solid rgba(192,57,43,.22);padding:12px 14px;margin-top:16px;font-size:.78rem}
.notice p{color:#e07b73;margin-bottom:3px}
.notice .ct{color:var(--gold);font-family:Cinzel,serif;font-size:.74rem;margin-top:6px}
.proc{font-size:.82rem;color:var(--muted);line-height:1.65;margin-bottom:18px;font-style:italic}
.frow{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:10px}
.field{display:flex;flex-direction:column;gap:4px;margin-bottom:10px}
.field label{font-family:Cinzel,serif;font-size:7.5px;letter-spacing:.17em;text-transform:uppercase;color:var(--muted)}
.field label .req{color:var(--gold);margin-left:1px}
input,select{background:rgba(255,255,255,.03);border:1px solid var(--border);color:var(--text);padding:8px 10px;font-size:.85rem;outline:none;width:100%;transition:border-color .25s,background .25s}
input:focus,select:focus{border-color:var(--gold-dim);background:rgba(201,168,76,.05)}
select{cursor:pointer}
select option{background:#1a1a1a}
.ph{display:flex}
.pfx{background:rgba(201,168,76,.1);border:1px solid var(--border);border-right:none;padding:8px 8px;color:var(--gold);font-family:Cinzel,serif;font-size:.74rem;white-space:nowrap}
.ph input{border-left:none}
.cg{display:flex;flex-direction:column;gap:7px}
.ci{display:flex;align-items:center;gap:8px;cursor:pointer;font-size:.82rem}
.ci input{width:14px;height:14px;accent-color:var(--gold);cursor:pointer;flex-shrink:0}
.fgl{font-family:Cinzel,serif;font-size:7.5px;letter-spacing:.17em;text-transform:uppercase;color:var(--muted);margin-bottom:8px;display:block}
.fl{border:1px dashed var(--border);padding:10px 12px;display:flex;align-items:center;gap:10px;cursor:pointer;background:rgba(255,255,255,.02);font-size:.82rem;color:var(--muted);transition:border-color .25s,background .25s}
.fl:hover{border-color:var(--gold-dim);background:rgba(201,168,76,.04)}
.fl-icon{color:var(--gold);font-size:1rem}
.btn{width:100%;margin-top:18px;padding:13px 24px;background:transparent;border:1px solid var(--gold);color:var(--gold-light);font-family:Cinzel,serif;font-size:.75rem;letter-spacing:.2em;text-transform:uppercase;cursor:pointer;position:relative;overflow:hidden;transition:color .3s}
.btn::before{content:'';position:absolute;inset:0;background:var(--gold);transform:scaleX(0);transform-origin:left;transition:transform .35s cubic-bezier(.4,0,.2,1);z-index:0}
.btn:hover::before{transform:scaleX(1)}
.btn:hover{color:var(--black)}
.btn span{position:relative;z-index:1}
@keyframes fd{from{opacity:0;transform:translateY(-22px)}to{opacity:1;transform:translateY(0)}}
@keyframes fu{from{opacity:0;transform:translateY(26px)}to{opacity:1;transform:translateY(0)}}
.error-text{color:var(--red);font-size:.75rem;margin-top:4px;display:block}
.help-hint{color:var(--muted);font-size:.75rem;margin-top:4px;font-style:italic;display:block}
    </style>
</head>
<body>

<div class="wrap">
  <header class="hd">
    <div class="tag">◆ Trade Campus ◆</div>
    <h1>Enroll for <em>Batch-23</em></h1>
    <div class="prices"><span class="old">$250</span><span class="new">$200</span></div>
    <div style="color:var(--muted);font-size:.74rem;margin-top:6px;font-style:italic">*Terms & Conditions Apply</div>
  </header>
  <div class="div"><span></span><span style="color:var(--gold);font-size:8px">◆</span><span></span></div>
  <div class="grid">
    <div class="panel">
      <div class="ptitle">Payment Details</div>
      <p class="proc">Pay $200 in favour of <strong style="color:var(--text)">Trade Campus</strong> and attach payment proof. Team contacts you within <strong style="color:var(--gold)">48 hours</strong> via email or WhatsApp.</p>
      <div class="bb">
        <div class="bname">🏦 Meezan Bank — Tulsa Road</div>
        <div class="br"><span class="lb">IBAN</span><span>PK88MEZN0008230109103971</span></div>
        <div class="br"><span class="lb">Title</span><span>BADAR TANVIR ENTERPRISES (SMC-PRIVATE) LTD</span></div>
        <div class="br"><span class="lb">SWIFT</span><span>MEZNPKKA</span></div>
      </div>
      <div class="bb">
        <div class="bname">🔶 Binance Pay</div>
        <div class="br"><span class="lb">Pay ID</span><span>81442671</span></div>
        <div class="br"><span class="lb">TRC20</span><span style="font-size:.72rem">TX9cFkKCu3hLfmoLnAkuZtBX5MqHiSb6oh</span></div>
      </div>
      <div class="notice">
        <p>⚠ After payment, wait <strong>48 hours</strong> for verification.</p>
        <p>For delays or issues, contact:</p>
        <div class="ct">📲 +92 333 9073110</div>
      </div>
    </div>
    <div class="panel">
      <div class="ptitle">Enrollment Form</div>
      <form method="POST" action="{{ route('enrollment.store') }}" enctype="multipart/form-data">
        @csrf
        
        <div class="frow">
          <div class="field">
            <label>First Name <span class="req">*</span></label>
            <input type="text" name="first_name" placeholder="John" value="{{ old('first_name') }}" required>
            @error('first_name')<span class="error-text">{{ $message }}</span>@enderror
          </div>
          <div class="field">
            <label>Last Name</label>
            <input type="text" name="last_name" placeholder="Doe" value="{{ old('last_name') }}">
          </div>
        </div>
        
        <div class="field">
          <label>Email Address <span class="req">*</span></label>
          <input type="email" name="email" placeholder="john@example.com" value="{{ old('email') }}" required>
          @error('email')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        
        <div class="field">
          <label>WhatsApp Number <span class="req">*</span></label>
          <div class="ph">
            <span class="pfx">+</span>
            <input type="tel" name="whatsapp_number" placeholder="1234567890" value="{{ old('whatsapp_number') }}" required>
          </div>
          <span class="help-hint">Enter number with country code (e.g., 923001234567)</span>
          @error('whatsapp_number')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        
        <div class="field">
          <label>Country <span class="req">*</span></label>
          <select name="country" required>
            <option value="">Select your country</option>
            <option value="Afghanistan" {{ old('country') === 'Afghanistan' ? 'selected' : '' }}>Afghanistan</option>
            <option value="Albania" {{ old('country') === 'Albania' ? 'selected' : '' }}>Albania</option>
            <option value="Algeria" {{ old('country') === 'Algeria' ? 'selected' : '' }}>Algeria</option>
            <option value="Andorra" {{ old('country') === 'Andorra' ? 'selected' : '' }}>Andorra</option>
            <option value="Angola" {{ old('country') === 'Angola' ? 'selected' : '' }}>Angola</option>
            <option value="Argentina" {{ old('country') === 'Argentina' ? 'selected' : '' }}>Argentina</option>
            <option value="Australia" {{ old('country') === 'Australia' ? 'selected' : '' }}>Australia</option>
            <option value="Austria" {{ old('country') === 'Austria' ? 'selected' : '' }}>Austria</option>
            <option value="Azerbaijan" {{ old('country') === 'Azerbaijan' ? 'selected' : '' }}>Azerbaijan</option>
            <option value="Bahamas" {{ old('country') === 'Bahamas' ? 'selected' : '' }}>Bahamas</option>
            <option value="Bahrain" {{ old('country') === 'Bahrain' ? 'selected' : '' }}>Bahrain</option>
            <option value="Bangladesh" {{ old('country') === 'Bangladesh' ? 'selected' : '' }}>Bangladesh</option>
            <option value="Barbados" {{ old('country') === 'Barbados' ? 'selected' : '' }}>Barbados</option>
            <option value="Belarus" {{ old('country') === 'Belarus' ? 'selected' : '' }}>Belarus</option>
            <option value="Belgium" {{ old('country') === 'Belgium' ? 'selected' : '' }}>Belgium</option>
            <option value="Belize" {{ old('country') === 'Belize' ? 'selected' : '' }}>Belize</option>
            <option value="Benin" {{ old('country') === 'Benin' ? 'selected' : '' }}>Benin</option>
            <option value="Bhutan" {{ old('country') === 'Bhutan' ? 'selected' : '' }}>Bhutan</option>
            <option value="Bolivia" {{ old('country') === 'Bolivia' ? 'selected' : '' }}>Bolivia</option>
            <option value="Bosnia and Herzegovina" {{ old('country') === 'Bosnia and Herzegovina' ? 'selected' : '' }}>Bosnia and Herzegovina</option>
            <option value="Botswana" {{ old('country') === 'Botswana' ? 'selected' : '' }}>Botswana</option>
            <option value="Brazil" {{ old('country') === 'Brazil' ? 'selected' : '' }}>Brazil</option>
            <option value="Brunei" {{ old('country') === 'Brunei' ? 'selected' : '' }}>Brunei</option>
            <option value="Bulgaria" {{ old('country') === 'Bulgaria' ? 'selected' : '' }}>Bulgaria</option>
            <option value="Burkina Faso" {{ old('country') === 'Burkina Faso' ? 'selected' : '' }}>Burkina Faso</option>
            <option value="Burundi" {{ old('country') === 'Burundi' ? 'selected' : '' }}>Burundi</option>
            <option value="Cambodia" {{ old('country') === 'Cambodia' ? 'selected' : '' }}>Cambodia</option>
            <option value="Cameroon" {{ old('country') === 'Cameroon' ? 'selected' : '' }}>Cameroon</option>
            <option value="Canada" {{ old('country') === 'Canada' ? 'selected' : '' }}>Canada</option>
            <option value="Cape Verde" {{ old('country') === 'Cape Verde' ? 'selected' : '' }}>Cape Verde</option>
            <option value="Central African Republic" {{ old('country') === 'Central African Republic' ? 'selected' : '' }}>Central African Republic</option>
            <option value="Chad" {{ old('country') === 'Chad' ? 'selected' : '' }}>Chad</option>
            <option value="Chile" {{ old('country') === 'Chile' ? 'selected' : '' }}>Chile</option>
            <option value="China" {{ old('country') === 'China' ? 'selected' : '' }}>China</option>
            <option value="Colombia" {{ old('country') === 'Colombia' ? 'selected' : '' }}>Colombia</option>
            <option value="Comoros" {{ old('country') === 'Comoros' ? 'selected' : '' }}>Comoros</option>
            <option value="Congo" {{ old('country') === 'Congo' ? 'selected' : '' }}>Congo</option>
            <option value="Costa Rica" {{ old('country') === 'Costa Rica' ? 'selected' : '' }}>Costa Rica</option>
            <option value="Croatia" {{ old('country') === 'Croatia' ? 'selected' : '' }}>Croatia</option>
            <option value="Cuba" {{ old('country') === 'Cuba' ? 'selected' : '' }}>Cuba</option>
            <option value="Cyprus" {{ old('country') === 'Cyprus' ? 'selected' : '' }}>Cyprus</option>
            <option value="Czech Republic" {{ old('country') === 'Czech Republic' ? 'selected' : '' }}>Czech Republic</option>
            <option value="Denmark" {{ old('country') === 'Denmark' ? 'selected' : '' }}>Denmark</option>
            <option value="Djibouti" {{ old('country') === 'Djibouti' ? 'selected' : '' }}>Djibouti</option>
            <option value="Dominica" {{ old('country') === 'Dominica' ? 'selected' : '' }}>Dominica</option>
            <option value="Dominican Republic" {{ old('country') === 'Dominican Republic' ? 'selected' : '' }}>Dominican Republic</option>
            <option value="Ecuador" {{ old('country') === 'Ecuador' ? 'selected' : '' }}>Ecuador</option>
            <option value="Egypt" {{ old('country') === 'Egypt' ? 'selected' : '' }}>Egypt</option>
            <option value="El Salvador" {{ old('country') === 'El Salvador' ? 'selected' : '' }}>El Salvador</option>
            <option value="Equatorial Guinea" {{ old('country') === 'Equatorial Guinea' ? 'selected' : '' }}>Equatorial Guinea</option>
            <option value="Eritrea" {{ old('country') === 'Eritrea' ? 'selected' : '' }}>Eritrea</option>
            <option value="Estonia" {{ old('country') === 'Estonia' ? 'selected' : '' }}>Estonia</option>
            <option value="Eswatini" {{ old('country') === 'Eswatini' ? 'selected' : '' }}>Eswatini</option>
            <option value="Ethiopia" {{ old('country') === 'Ethiopia' ? 'selected' : '' }}>Ethiopia</option>
            <option value="Fiji" {{ old('country') === 'Fiji' ? 'selected' : '' }}>Fiji</option>
            <option value="Finland" {{ old('country') === 'Finland' ? 'selected' : '' }}>Finland</option>
            <option value="France" {{ old('country') === 'France' ? 'selected' : '' }}>France</option>
            <option value="Gabon" {{ old('country') === 'Gabon' ? 'selected' : '' }}>Gabon</option>
            <option value="Gambia" {{ old('country') === 'Gambia' ? 'selected' : '' }}>Gambia</option>
            <option value="Georgia" {{ old('country') === 'Georgia' ? 'selected' : '' }}>Georgia</option>
            <option value="Germany" {{ old('country') === 'Germany' ? 'selected' : '' }}>Germany</option>
            <option value="Ghana" {{ old('country') === 'Ghana' ? 'selected' : '' }}>Ghana</option>
            <option value="Greece" {{ old('country') === 'Greece' ? 'selected' : '' }}>Greece</option>
            <option value="Grenada" {{ old('country') === 'Grenada' ? 'selected' : '' }}>Grenada</option>
            <option value="Guatemala" {{ old('country') === 'Guatemala' ? 'selected' : '' }}>Guatemala</option>
            <option value="Guinea" {{ old('country') === 'Guinea' ? 'selected' : '' }}>Guinea</option>
            <option value="Guinea-Bissau" {{ old('country') === 'Guinea-Bissau' ? 'selected' : '' }}>Guinea-Bissau</option>
            <option value="Guyana" {{ old('country') === 'Guyana' ? 'selected' : '' }}>Guyana</option>
            <option value="Haiti" {{ old('country') === 'Haiti' ? 'selected' : '' }}>Haiti</option>
            <option value="Honduras" {{ old('country') === 'Honduras' ? 'selected' : '' }}>Honduras</option>
            <option value="Hungary" {{ old('country') === 'Hungary' ? 'selected' : '' }}>Hungary</option>
            <option value="Iceland" {{ old('country') === 'Iceland' ? 'selected' : '' }}>Iceland</option>
            <option value="India" {{ old('country') === 'India' ? 'selected' : '' }}>India</option>
            <option value="Indonesia" {{ old('country') === 'Indonesia' ? 'selected' : '' }}>Indonesia</option>
            <option value="Iran" {{ old('country') === 'Iran' ? 'selected' : '' }}>Iran</option>
            <option value="Iraq" {{ old('country') === 'Iraq' ? 'selected' : '' }}>Iraq</option>
            <option value="Ireland" {{ old('country') === 'Ireland' ? 'selected' : '' }}>Ireland</option>
            <option value="Israel" {{ old('country') === 'Israel' ? 'selected' : '' }}>Israel</option>
            <option value="Italy" {{ old('country') === 'Italy' ? 'selected' : '' }}>Italy</option>
            <option value="Jamaica" {{ old('country') === 'Jamaica' ? 'selected' : '' }}>Jamaica</option>
            <option value="Japan" {{ old('country') === 'Japan' ? 'selected' : '' }}>Japan</option>
            <option value="Jordan" {{ old('country') === 'Jordan' ? 'selected' : '' }}>Jordan</option>
            <option value="Kazakhstan" {{ old('country') === 'Kazakhstan' ? 'selected' : '' }}>Kazakhstan</option>
            <option value="Kenya" {{ old('country') === 'Kenya' ? 'selected' : '' }}>Kenya</option>
            <option value="Kiribati" {{ old('country') === 'Kiribati' ? 'selected' : '' }}>Kiribati</option>
            <option value="Kosovo" {{ old('country') === 'Kosovo' ? 'selected' : '' }}>Kosovo</option>
            <option value="Kuwait" {{ old('country') === 'Kuwait' ? 'selected' : '' }}>Kuwait</option>
            <option value="Kyrgyzstan" {{ old('country') === 'Kyrgyzstan' ? 'selected' : '' }}>Kyrgyzstan</option>
            <option value="Laos" {{ old('country') === 'Laos' ? 'selected' : '' }}>Laos</option>
            <option value="Latvia" {{ old('country') === 'Latvia' ? 'selected' : '' }}>Latvia</option>
            <option value="Lebanon" {{ old('country') === 'Lebanon' ? 'selected' : '' }}>Lebanon</option>
            <option value="Lesotho" {{ old('country') === 'Lesotho' ? 'selected' : '' }}>Lesotho</option>
            <option value="Liberia" {{ old('country') === 'Liberia' ? 'selected' : '' }}>Liberia</option>
            <option value="Libya" {{ old('country') === 'Libya' ? 'selected' : '' }}>Libya</option>
            <option value="Liechtenstein" {{ old('country') === 'Liechtenstein' ? 'selected' : '' }}>Liechtenstein</option>
            <option value="Lithuania" {{ old('country') === 'Lithuania' ? 'selected' : '' }}>Lithuania</option>
            <option value="Luxembourg" {{ old('country') === 'Luxembourg' ? 'selected' : '' }}>Luxembourg</option>
            <option value="Madagascar" {{ old('country') === 'Madagascar' ? 'selected' : '' }}>Madagascar</option>
            <option value="Malawi" {{ old('country') === 'Malawi' ? 'selected' : '' }}>Malawi</option>
            <option value="Malaysia" {{ old('country') === 'Malaysia' ? 'selected' : '' }}>Malaysia</option>
            <option value="Maldives" {{ old('country') === 'Maldives' ? 'selected' : '' }}>Maldives</option>
            <option value="Mali" {{ old('country') === 'Mali' ? 'selected' : '' }}>Mali</option>
            <option value="Malta" {{ old('country') === 'Malta' ? 'selected' : '' }}>Malta</option>
            <option value="Marshall Islands" {{ old('country') === 'Marshall Islands' ? 'selected' : '' }}>Marshall Islands</option>
            <option value="Mauritania" {{ old('country') === 'Mauritania' ? 'selected' : '' }}>Mauritania</option>
            <option value="Mauritius" {{ old('country') === 'Mauritius' ? 'selected' : '' }}>Mauritius</option>
            <option value="Mexico" {{ old('country') === 'Mexico' ? 'selected' : '' }}>Mexico</option>
            <option value="Micronesia" {{ old('country') === 'Micronesia' ? 'selected' : '' }}>Micronesia</option>
            <option value="Moldova" {{ old('country') === 'Moldova' ? 'selected' : '' }}>Moldova</option>
            <option value="Monaco" {{ old('country') === 'Monaco' ? 'selected' : '' }}>Monaco</option>
            <option value="Mongolia" {{ old('country') === 'Mongolia' ? 'selected' : '' }}>Mongolia</option>
            <option value="Montenegro" {{ old('country') === 'Montenegro' ? 'selected' : '' }}>Montenegro</option>
            <option value="Morocco" {{ old('country') === 'Morocco' ? 'selected' : '' }}>Morocco</option>
            <option value="Mozambique" {{ old('country') === 'Mozambique' ? 'selected' : '' }}>Mozambique</option>
            <option value="Myanmar" {{ old('country') === 'Myanmar' ? 'selected' : '' }}>Myanmar</option>
            <option value="Namibia" {{ old('country') === 'Namibia' ? 'selected' : '' }}>Namibia</option>
            <option value="Nauru" {{ old('country') === 'Nauru' ? 'selected' : '' }}>Nauru</option>
            <option value="Nepal" {{ old('country') === 'Nepal' ? 'selected' : '' }}>Nepal</option>
            <option value="Netherlands" {{ old('country') === 'Netherlands' ? 'selected' : '' }}>Netherlands</option>
            <option value="New Zealand" {{ old('country') === 'New Zealand' ? 'selected' : '' }}>New Zealand</option>
            <option value="Nicaragua" {{ old('country') === 'Nicaragua' ? 'selected' : '' }}>Nicaragua</option>
            <option value="Niger" {{ old('country') === 'Niger' ? 'selected' : '' }}>Niger</option>
            <option value="Nigeria" {{ old('country') === 'Nigeria' ? 'selected' : '' }}>Nigeria</option>
            <option value="North Korea" {{ old('country') === 'North Korea' ? 'selected' : '' }}>North Korea</option>
            <option value="North Macedonia" {{ old('country') === 'North Macedonia' ? 'selected' : '' }}>North Macedonia</option>
            <option value="Norway" {{ old('country') === 'Norway' ? 'selected' : '' }}>Norway</option>
            <option value="Oman" {{ old('country') === 'Oman' ? 'selected' : '' }}>Oman</option>
            <option value="Pakistan" {{ old('country') === 'Pakistan' ? 'selected' : '' }}>Pakistan</option>
            <option value="Palau" {{ old('country') === 'Palau' ? 'selected' : '' }}>Palau</option>
            <option value="Palestine" {{ old('country') === 'Palestine' ? 'selected' : '' }}>Palestine</option>
            <option value="Panama" {{ old('country') === 'Panama' ? 'selected' : '' }}>Panama</option>
            <option value="Papua New Guinea" {{ old('country') === 'Papua New Guinea' ? 'selected' : '' }}>Papua New Guinea</option>
            <option value="Paraguay" {{ old('country') === 'Paraguay' ? 'selected' : '' }}>Paraguay</option>
            <option value="Peru" {{ old('country') === 'Peru' ? 'selected' : '' }}>Peru</option>
            <option value="Philippines" {{ old('country') === 'Philippines' ? 'selected' : '' }}>Philippines</option>
            <option value="Poland" {{ old('country') === 'Poland' ? 'selected' : '' }}>Poland</option>
            <option value="Portugal" {{ old('country') === 'Portugal' ? 'selected' : '' }}>Portugal</option>
            <option value="Qatar" {{ old('country') === 'Qatar' ? 'selected' : '' }}>Qatar</option>
            <option value="Romania" {{ old('country') === 'Romania' ? 'selected' : '' }}>Romania</option>
            <option value="Russia" {{ old('country') === 'Russia' ? 'selected' : '' }}>Russia</option>
            <option value="Rwanda" {{ old('country') === 'Rwanda' ? 'selected' : '' }}>Rwanda</option>
            <option value="Saint Kitts and Nevis" {{ old('country') === 'Saint Kitts and Nevis' ? 'selected' : '' }}>Saint Kitts and Nevis</option>
            <option value="Saint Lucia" {{ old('country') === 'Saint Lucia' ? 'selected' : '' }}>Saint Lucia</option>
            <option value="Saint Vincent and the Grenadines" {{ old('country') === 'Saint Vincent and the Grenadines' ? 'selected' : '' }}>Saint Vincent and the Grenadines</option>
            <option value="Samoa" {{ old('country') === 'Samoa' ? 'selected' : '' }}>Samoa</option>
            <option value="San Marino" {{ old('country') === 'San Marino' ? 'selected' : '' }}>San Marino</option>
            <option value="Sao Tome and Principe" {{ old('country') === 'Sao Tome and Principe' ? 'selected' : '' }}>Sao Tome and Principe</option>
            <option value="Saudi Arabia" {{ old('country') === 'Saudi Arabia' ? 'selected' : '' }}>Saudi Arabia</option>
            <option value="Senegal" {{ old('country') === 'Senegal' ? 'selected' : '' }}>Senegal</option>
            <option value="Serbia" {{ old('country') === 'Serbia' ? 'selected' : '' }}>Serbia</option>
            <option value="Seychelles" {{ old('country') === 'Seychelles' ? 'selected' : '' }}>Seychelles</option>
            <option value="Sierra Leone" {{ old('country') === 'Sierra Leone' ? 'selected' : '' }}>Sierra Leone</option>
            <option value="Singapore" {{ old('country') === 'Singapore' ? 'selected' : '' }}>Singapore</option>
            <option value="Slovakia" {{ old('country') === 'Slovakia' ? 'selected' : '' }}>Slovakia</option>
            <option value="Slovenia" {{ old('country') === 'Slovenia' ? 'selected' : '' }}>Slovenia</option>
            <option value="Solomon Islands" {{ old('country') === 'Solomon Islands' ? 'selected' : '' }}>Solomon Islands</option>
            <option value="Somalia" {{ old('country') === 'Somalia' ? 'selected' : '' }}>Somalia</option>
            <option value="South Africa" {{ old('country') === 'South Africa' ? 'selected' : '' }}>South Africa</option>
            <option value="South Korea" {{ old('country') === 'South Korea' ? 'selected' : '' }}>South Korea</option>
            <option value="South Sudan" {{ old('country') === 'South Sudan' ? 'selected' : '' }}>South Sudan</option>
            <option value="Spain" {{ old('country') === 'Spain' ? 'selected' : '' }}>Spain</option>
            <option value="Sri Lanka" {{ old('country') === 'Sri Lanka' ? 'selected' : '' }}>Sri Lanka</option>
            <option value="Sudan" {{ old('country') === 'Sudan' ? 'selected' : '' }}>Sudan</option>
            <option value="Suriname" {{ old('country') === 'Suriname' ? 'selected' : '' }}>Suriname</option>
            <option value="Sweden" {{ old('country') === 'Sweden' ? 'selected' : '' }}>Sweden</option>
            <option value="Switzerland" {{ old('country') === 'Switzerland' ? 'selected' : '' }}>Switzerland</option>
            <option value="Syria" {{ old('country') === 'Syria' ? 'selected' : '' }}>Syria</option>
            <option value="Taiwan" {{ old('country') === 'Taiwan' ? 'selected' : '' }}>Taiwan</option>
            <option value="Tajikistan" {{ old('country') === 'Tajikistan' ? 'selected' : '' }}>Tajikistan</option>
            <option value="Tanzania" {{ old('country') === 'Tanzania' ? 'selected' : '' }}>Tanzania</option>
            <option value="Thailand" {{ old('country') === 'Thailand' ? 'selected' : '' }}>Thailand</option>
            <option value="Timor-Leste" {{ old('country') === 'Timor-Leste' ? 'selected' : '' }}>Timor-Leste</option>
            <option value="Togo" {{ old('country') === 'Togo' ? 'selected' : '' }}>Togo</option>
            <option value="Tonga" {{ old('country') === 'Tonga' ? 'selected' : '' }}>Tonga</option>
            <option value="Trinidad and Tobago" {{ old('country') === 'Trinidad and Tobago' ? 'selected' : '' }}>Trinidad and Tobago</option>
            <option value="Tunisia" {{ old('country') === 'Tunisia' ? 'selected' : '' }}>Tunisia</option>
            <option value="Turkey" {{ old('country') === 'Turkey' ? 'selected' : '' }}>Turkey</option>
            <option value="Turkmenistan" {{ old('country') === 'Turkmenistan' ? 'selected' : '' }}>Turkmenistan</option>
            <option value="Tuvalu" {{ old('country') === 'Tuvalu' ? 'selected' : '' }}>Tuvalu</option>
            <option value="Uganda" {{ old('country') === 'Uganda' ? 'selected' : '' }}>Uganda</option>
            <option value="Ukraine" {{ old('country') === 'Ukraine' ? 'selected' : '' }}>Ukraine</option>
            <option value="United Arab Emirates" {{ old('country') === 'United Arab Emirates' ? 'selected' : '' }}>United Arab Emirates</option>
            <option value="United Kingdom" {{ old('country') === 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
            <option value="United States" {{ old('country') === 'United States' ? 'selected' : '' }}>United States</option>
            <option value="Uruguay" {{ old('country') === 'Uruguay' ? 'selected' : '' }}>Uruguay</option>
            <option value="Uzbekistan" {{ old('country') === 'Uzbekistan' ? 'selected' : '' }}>Uzbekistan</option>
            <option value="Vanuatu" {{ old('country') === 'Vanuatu' ? 'selected' : '' }}>Vanuatu</option>
            <option value="Vatican City" {{ old('country') === 'Vatican City' ? 'selected' : '' }}>Vatican City</option>
            <option value="Venezuela" {{ old('country') === 'Venezuela' ? 'selected' : '' }}>Venezuela</option>
            <option value="Vietnam" {{ old('country') === 'Vietnam' ? 'selected' : '' }}>Vietnam</option>
            <option value="Yemen" {{ old('country') === 'Yemen' ? 'selected' : '' }}>Yemen</option>
            <option value="Zambia" {{ old('country') === 'Zambia' ? 'selected' : '' }}>Zambia</option>
            <option value="Zimbabwe" {{ old('country') === 'Zimbabwe' ? 'selected' : '' }}>Zimbabwe</option>
          </select>
          @error('country')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        
        <div class="field" style="margin-bottom:14px">
          <span class="fgl">Experience</span>
          <div class="cg">
            <label class="ci">
              <input type="radio" name="experience" value="less_than_6_months" {{ old('experience') === 'less_than_6_months' ? 'checked' : '' }} required>
              Less than 6 months <em style="color:var(--muted);font-size:.78rem">(Beginners welcome)</em>
            </label>
            <label class="ci">
              <input type="radio" name="experience" value="more_than_6_months" {{ old('experience') === 'more_than_6_months' ? 'checked' : '' }}>
              More than 6 months
            </label>
          </div>
          @error('experience')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        
        <div class="field" style="margin-bottom:14px">
          <span class="fgl">Enrollment Type</span>
          <label class="ci">
            <input type="radio" name="enrollment_type" value="online_lectures" checked>
            Online Lectures — $200
          </label>
        </div>
        
        <div class="field">
          <label>Select Course <span class="req">*</span></label>
          <select name="course" required>
            <option value="Advanced Liquidity Bootcamp Batch 23">Advanced Liquidity Bootcamp Batch 23</option>
          </select>
        </div>
        
        <div class="field">
          <label>Payment Screenshot <span class="req">*</span></label>
          <div class="fl" id="fileInput">
            <span class="fl-icon">📎</span>
            <div>
              <div>Click to attach payment proof</div>
              <div style="color:var(--muted);font-size:.75rem" id="fileName">No file chosen</div>
            </div>
          </div>
          <input type="file" name="payment_screenshot" id="paymentFile" style="display:none" accept="image/*" required>
          @error('payment_screenshot')<span class="error-text">{{ $message }}</span>@enderror
        </div>
        
        @if($errors->any())
          <div style="background:rgba(192,57,43,.1);border:1px solid rgba(192,57,43,.3);border-left:3px solid var(--red);padding:12px;margin:16px 0;color:#e07b73;font-size:.85rem">
            <strong>Please fix the errors above:</strong>
            <ul style="margin-left:20px;margin-top:8px">
              @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
        
        <button type="submit" class="btn"><span>Submit Enrollment →</span></button>
      </form>
    </div>
  </div>
</div>

<script>
document.getElementById('fileInput').addEventListener('click', function() {
  document.getElementById('paymentFile').click();
});

document.getElementById('paymentFile').addEventListener('change', function(e) {
  const fileName = this.files[0]?.name || 'No file chosen';
  document.getElementById('fileName').textContent = fileName;
});
</script>
</body>
</html>
