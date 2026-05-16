        {{-- â”€â”€ STAT CARDS â”€â”€ --}}
        <div class="stats-grid">
            <div class="stat-card" style="animation-delay:.05s">
                <div class="sc-top">
                    <span class="sc-label">Total Members</span>
                    <div class="sc-icon"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg></div>
                </div>
                <div class="sc-value">320,481</div>
                <div class="sc-change up">
                    <svg viewBox="0 0 24 24"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                    +12.4% this month
                </div>
                <div class="sc-bar"><div class="sc-bar-fill" data-w="78"></div></div>
            </div>
            <div class="stat-card" style="animation-delay:.1s">
                <div class="sc-top">
                    <span class="sc-label">Trading Volume</span>
                    <div class="sc-icon"><svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg></div>
                </div>
                <div class="sc-value">$4.2B</div>
                <div class="sc-change up">
                    <svg viewBox="0 0 24 24"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                    +8.7% this month
                </div>
                <div class="sc-bar"><div class="sc-bar-fill" data-w="85"></div></div>
            </div>
            <div class="stat-card" style="animation-delay:.15s">
                <div class="sc-top">
                    <span class="sc-label">Active Courses</span>
                    <div class="sc-icon"><svg viewBox="0 0 24 24"><path d="M22 10L12 5 2 10l10 5 10-5z"/><path d="M6 12v5c3.33 1.67 8.67 1.67 12 0v-5"/></svg></div>
                </div>
                <div class="sc-value">40</div>
                <div class="sc-change up">
                    <svg viewBox="0 0 24 24"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
                    +3 new this week
                </div>
                <div class="sc-bar"><div class="sc-bar-fill" data-w="55"></div></div>
            </div>
            <div class="stat-card" style="animation-delay:.2s">
                <div class="sc-top">
                    <span class="sc-label">P2P Trades</span>
                    <div class="sc-icon"><svg viewBox="0 0 24 24"><path d="M17 1l4 4-4 4M3 11V9a4 4 0 014-4h14M7 23l-4-4 4-4M21 13v2a4 4 0 01-4 4H3"/></svg></div>
                </div>
                <div class="sc-value">8,934</div>
                <div class="sc-change down">
                    <svg viewBox="0 0 24 24"><polyline points="23 18 13.5 8.5 8.5 13.5 1 6"/><polyline points="17 18 23 18 23 12"/></svg>
                    -2.1% this week
                </div>
                <div class="sc-bar"><div class="sc-bar-fill" data-w="62"></div></div>
            </div>
        </div>

        {{-- â”€â”€ CHART + ACTIVITY â”€â”€ --}}
        <div class="main-grid">

            {{-- Chart --}}
            <div class="chart-card">
                <div class="card-header">
                    <div class="card-title">Revenue Overview</div>
                    <div class="card-filters">
                        <button class="cf-btn">7D</button>
                        <button class="cf-btn active">30D</button>
                        <button class="cf-btn">90D</button>
                        <button class="cf-btn">1Y</button>
                    </div>
                </div>
                <div class="chart-wrap">
                    <svg class="chart-svg" viewBox="0 0 700 200" preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="chartGrad" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#D4A017" stop-opacity=".35"/>
                                <stop offset="100%" stop-color="#D4A017" stop-opacity="0"/>
                            </linearGradient>
                            <linearGradient id="lineGrad" x1="0" y1="0" x2="1" y2="0">
                                <stop offset="0%" stop-color="#A07810"/>
                                <stop offset="50%" stop-color="#F5C842"/>
                                <stop offset="100%" stop-color="#D4A017"/>
                            </linearGradient>
                        </defs>
                        <!-- Grid lines -->
                        <line class="chart-grid-line" x1="0" y1="50" x2="700" y2="50"/>
                        <line class="chart-grid-line" x1="0" y1="100" x2="700" y2="100"/>
                        <line class="chart-grid-line" x1="0" y1="150" x2="700" y2="150"/>
                        <!-- Area -->
                        <path class="chart-area" d="M0,160 C50,140 80,120 120,100 C160,80 180,110 230,90 C280,70 310,50 360,60 C410,70 440,40 490,30 C540,20 570,45 620,35 C650,28 680,22 700,18 L700,200 L0,200 Z"/>
                        <!-- Line -->
                        <path class="chart-line" d="M0,160 C50,140 80,120 120,100 C160,80 180,110 230,90 C280,70 310,50 360,60 C410,70 440,40 490,30 C540,20 570,45 620,35 C650,28 680,22 700,18"/>
                        <!-- Dots -->
                        <circle class="chart-dot" cx="120" cy="100" r="4"/>
                        <circle class="chart-dot" cx="360" cy="60" r="4"/>
                        <circle class="chart-dot" cx="490" cy="30" r="4"/>
                        <circle class="chart-dot" cx="700" cy="18" r="4"/>
                    </svg>
                </div>
            </div>

            {{-- Activity Feed --}}
            <div class="side-stack">
                <div class="activity-card">
                    <div class="card-header" style="margin-bottom:14px">
                        <div class="card-title">Recent Activity</div>
                    </div>
                    <div class="activity-list">
                        <div class="act-item">
                            <span class="act-dot green"></span>
                            <div>
                                <div class="act-text"><strong>Ahmed K.</strong> joined Premium Group</div>
                                <div class="act-time">2 min ago</div>
                            </div>
                        </div>
                        <div class="act-item">
                            <span class="act-dot gold"></span>
                            <div>
                                <div class="act-text"><strong>New signal</strong> published â€” BTC/USDT Long</div>
                                <div class="act-time">8 min ago</div>
                            </div>
                        </div>
                        <div class="act-item">
                            <span class="act-dot blue"></span>
                            <div>
                                <div class="act-text"><strong>Sara M.</strong> enrolled in DeFi Mastery course</div>
                                <div class="act-time">15 min ago</div>
                            </div>
                        </div>
                        <div class="act-item">
                            <span class="act-dot gold"></span>
                            <div>
                                <div class="act-text"><strong>Live session</strong> started â€” ETH Market Analysis</div>
                                <div class="act-time">22 min ago</div>
                            </div>
                        </div>
                        <div class="act-item">
                            <span class="act-dot red"></span>
                            <div>
                                <div class="act-text"><strong>P2P trade</strong> #8934 disputed â€” review needed</div>
                                <div class="act-time">34 min ago</div>
                            </div>
                        </div>
                        <div class="act-item">
                            <span class="act-dot green"></span>
                            <div>
                                <div class="act-text"><strong>Omar R.</strong> completed Bitcoin Basics course</div>
                                <div class="act-time">1 hr ago</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- â”€â”€ TABLE + QUICK ACTIONS â”€â”€ --}}
        <div class="bottom-grid">

            {{-- Members table --}}
            <div class="table-card">
                <div class="card-header">
                    <div class="card-title">Recent Members</div>
                    <a href="{{ url('/admin/users') }}" class="btn-sm btn-outline-gold" style="font-size:.55rem;padding:6px 14px">View All</a>
                </div>
                <table class="data-table" aria-label="Recent members">
                    <thead>
                        <tr>
                            <th>Member</th>
                            <th>Plan</th>
                            <th>Status</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><div class="td-user"><div class="td-avatar">A</div><div><div class="td-name">Ahmed Khan</div><div class="td-email">ahmed@email.com</div></div></div></td>
                            <td><span class="pill pill-gold">Premium</span></td>
                            <td><span class="pill pill-green">Active</span></td>
                            <td style="color:var(--wf);font-size:.82rem">Today</td>
                        </tr>
                        <tr>
                            <td><div class="td-user"><div class="td-avatar">S</div><div><div class="td-name">Sara Malik</div><div class="td-email">sara@email.com</div></div></div></td>
                            <td><span class="pill pill-blue">Courses</span></td>
                            <td><span class="pill pill-green">Active</span></td>
                            <td style="color:var(--wf);font-size:.82rem">Yesterday</td>
                        </tr>
                        <tr>
                            <td><div class="td-user"><div class="td-avatar">O</div><div><div class="td-name">Omar Raza</div><div class="td-email">omar@email.com</div></div></div></td>
                            <td><span class="pill pill-gold">Premium</span></td>
                            <td><span class="pill pill-green">Active</span></td>
                            <td style="color:var(--wf);font-size:.82rem">2 days ago</td>
                        </tr>
                        <tr>
                            <td><div class="td-user"><div class="td-avatar">F</div><div><div class="td-name">Fatima Ali</div><div class="td-email">fatima@email.com</div></div></div></td>
                            <td><span class="pill pill-blue">P2P</span></td>
                            <td><span class="pill pill-red">Pending</span></td>
                            <td style="color:var(--wf);font-size:.82rem">3 days ago</td>
                        </tr>
                        <tr>
                            <td><div class="td-user"><div class="td-avatar">Z</div><div><div class="td-name">Zain Butt</div><div class="td-email">zain@email.com</div></div></div></td>
                            <td><span class="pill pill-gold">Premium</span></td>
                            <td><span class="pill pill-green">Active</span></td>
                            <td style="color:var(--wf);font-size:.82rem">4 days ago</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Quick Actions --}}
            <div class="qa-card">
                <div class="card-title">Quick Actions</div>
                <div class="qa-list">
                    <button class="qa-btn">
                        <div class="qa-btn-icon"><svg viewBox="0 0 24 24"><path d="M12 20h9M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"/></svg></div>
                        <span>Publish Signal</span>
                    </button>
                    <button class="qa-btn">
                        <div class="qa-btn-icon"><svg viewBox="0 0 24 24"><rect x="2" y="7" width="15" height="10" rx="1"/><path d="M17 9l5-2v10l-5-2V9z"/></svg></div>
                        <span>Start Live Session</span>
                    </button>
                    <button class="qa-btn">
                        <div class="qa-btn-icon"><svg viewBox="0 0 24 24"><path d="M22 10L12 5 2 10l10 5 10-5z"/><path d="M6 12v5c3.33 1.67 8.67 1.67 12 0v-5"/></svg></div>
                        <span>Add New Course</span>
                    </button>
                    <button class="qa-btn">
                        <div class="qa-btn-icon"><svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></div>
                        <span>Send Newsletter</span>
                    </button>
                    <button class="qa-btn">
                        <div class="qa-btn-icon"><svg viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M8 10l4-4 4 4M8 14l4 4 4-4"/></svg></div>
                        <span>Update Hero Slider</span>
                    </button>
                    <button class="qa-btn">
                        <div class="qa-btn-icon"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg></div>
                        <span>Invite Member</span>
                    </button>
                </div>
            </div>

        </div>

    </main>

    {{-- â”€â”€ FOOTER â”€â”€ --}}
    <footer class="admin-footer">
        <p class="af-copy">&copy; {{ date('Y') }} <span>CryptoOnly</span> Admin Panel. All rights reserved.</p>
        <nav class="af-links" aria-label="Admin footer links">
            <a href="{{ url('/admin/settings') }}">Settings</a>
            <a href="{{ url('/admin/help') }}">Help</a>
            <a href="{{ url('/') }}" target="_blank">View Site</a>
