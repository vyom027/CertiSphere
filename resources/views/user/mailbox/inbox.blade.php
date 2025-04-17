{{-- <!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inbox - CertiSphere</title>

    <!-- CSS FILES -->        
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap" rel="stylesheet">
    <link href="{{ asset('student/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('student/css/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{ asset('student/css/email.css')}}" rel="stylesheet">
    <link href="{{ asset('student/css/templatemo-topic-listing.css')}}" rel="stylesheet">
</head>

<body>
    @include('user.components.navbar')
    <div class="pagination-controls" style="text-align: center; margin: 15px 0;">
        @if($page > 1)
        <form method="POST" action="{{ route('mailbox.connect') }}">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <input type="hidden" name="password" value="{{ request('password') }}">
            <input type="hidden" name="page" value="{{ $page - 1 }}">
            <button type="submit" {{ $page <= 1 ? 'disabled' : '' }}>Previous</button>
        </form>
        
        
        @endif

        <span>Page {{ $page }} of {{ $total_pages }}</span>

        @if($page < $total_pages)
        
        <form method="POST" action="{{ route('mailbox.connect') }}">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">
            <input type="hidden" name="password" value="{{ request('password') }}">
            <input type="hidden" name="page" value="{{ $page + 1 }}">
            <button type="submit" {{ $page >= $total_pages ? 'disabled' : '' }}>Next</button>
        </form>

        @endif

    </div>
    <div class="mail-container" style="margin-top: 0">
        <div class="mail-header">
            <h2>Mail Inbox</h2>
            <p>{{ $email }}</p>
        </div>
        
        <div class="inbox-container">
            <!-- Email List -->
            <div class="email-list" id="email-list">
                <!-- JavaScript will insert emails here -->
            </div>

            <!-- Pagination Controls -->
            

            <!-- Email Preview -->
            <div class="email-preview">
                <div class="preview-placeholder">
                    <i class="bi bi-envelope"></i>
                    <p>Select an email to view its content</p>
                </div>
                <div class="email-content">
                    <div class="email-content-header">
                        <div class="email-content-title"></div>
                        <div class="email-content-meta">
                            <div class="from"></div>
                            <div class="date"></div>
                        </div>
                    </div>
                    <div class="warning-box" style="display: none;">
                        <i class="bi bi-exclamation-triangle"></i>
                        <div>
                            External images are not displayed. <a href="#" class="display-images">Display images</a><br>
                            Always display images sent from <span class="trusted-sender"></span>
                        </div>
                        <div class="warning-close">&times;</div>
                    </div>
                    <div class="email-content-body"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const messages = @json($messages);
        const emailsPerPage = 10;
        let currentPage = 1;

        function renderEmailList(page = 1) {
            const emailList = document.getElementById('email-list');
            emailList.innerHTML = '';

            const start = (page - 1) * emailsPerPage;
            const end = start + emailsPerPage;
            const paginatedEmails = messages.slice(start, end);

            if (paginatedEmails.length === 0) {
                emailList.innerHTML = '<div class="email-item"><div class="email-title">No messages found</div></div>';
                return;
            }

            paginatedEmails.forEach((message, index) => {
                const fromMatch = message.from.match(/<(.+)>/);
                const from = fromMatch ? fromMatch[1] : message.from;
                const item = document.createElement('div');
                item.classList.add('email-item');
                item.dataset.subject = message.subject ?? 'No Subject';
                item.dataset.from = from;
                item.dataset.date = message.date ?? 'No Date';
                item.dataset.body = message.body ?? '';
                item.dataset.rawFrom = message.from ?? '';

                item.innerHTML = `
                    <div class="email-title">${message.subject ?? 'No Subject'}</div>
                    <div class="email-meta">
                        <div class="email-sender">${from}</div>
                        <div class="email-date">${message.date ?? 'No Date'}</div>
                    </div>
                `;

                item.addEventListener('click', function() {
                    document.querySelectorAll('.email-item').forEach(i => i.classList.remove('active'));
                    this.classList.add('active');

                    document.querySelector('.preview-placeholder').style.display = 'none';
                    document.querySelector('.email-content').style.display = 'block';

                    document.querySelector('.email-content-title').textContent = this.dataset.subject;
                    document.querySelector('.from').textContent = 'From: ' + this.dataset.rawFrom;
                    document.querySelector('.date').textContent = 'Date: ' + this.dataset.date;
                    document.querySelector('.trusted-sender').textContent = this.dataset.from;

                    let bodyContent = this.dataset.body;
                    if (bodyContent.includes('<body')) {
                        const tempDiv = document.createElement('div');
                        tempDiv.innerHTML = bodyContent;
                        const bodyElement = tempDiv.querySelector('body');
                        if (bodyElement) {
                            bodyContent = bodyElement.innerHTML;
                        }
                    }

                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = bodyContent;
                    const scripts = tempDiv.getElementsByTagName('script');
                    while(scripts[0]) scripts[0].parentNode.removeChild(scripts[0]);

                    const emailBody = document.querySelector('.email-content-body');
                    emailBody.innerHTML = tempDiv.innerHTML;

                    Array.from(emailBody.getElementsByTagName('a')).forEach(link => {
                        link.setAttribute('target', '_blank');
                        link.setAttribute('rel', 'noopener noreferrer');
                    });

                    const hasImages = emailBody.getElementsByTagName('img').length > 0;
                    document.querySelector('.warning-box').style.display = hasImages ? 'flex' : 'none';
                });

                emailList.appendChild(item);
            });

            // Update buttons
            document.getElementById('prevPage').disabled = currentPage === 1;
            document.getElementById('nextPage').disabled = end >= messages.length;
            document.getElementById('pageIndicator').textContent = `Page ${currentPage}`;
        }

        document.addEventListener('DOMContentLoaded', () => {
            renderEmailList(currentPage);

            document.getElementById('prevPage').addEventListener('click', () => {
                if (currentPage > 1) {
                    currentPage--;
                    renderEmailList(currentPage);
                }
            });

            document.getElementById('nextPage').addEventListener('click', () => {
                if ((currentPage * emailsPerPage) < messages.length) {
                    currentPage++;
                    renderEmailList(currentPage);
                }
            });

            document.querySelector('.warning-close').addEventListener('click', () => {
                document.querySelector('.warning-box').style.display = 'none';
            });

            document.querySelector('.display-images').addEventListener('click', function(e) {
                e.preventDefault();
                const images = document.querySelector('.email-content-body').getElementsByTagName('img');
                Array.from(images).forEach(img => img.style.display = 'inline');
                document.querySelector('.warning-box').style.display = 'none';
            });
        });
    </script>
</body>
</html> --}}
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inbox - CertiSphere</title>

    <!-- CSS FILES -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap" rel="stylesheet">
    <link href="{{ asset('student/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('student/css/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('student/css/email.css') }}" rel="stylesheet">
    <link href="{{ asset('student/css/templatemo-topic-listing.css') }}" rel="stylesheet">
</head>

<body>
    @include('user.components.navbar')

    <div class="container mt-4">
        <h2 class="text-center">Inbox</h2>
        <p class="text-center">Email: <strong>{{ $email }}</strong></p>

        <div class="pagination-controls d-flex justify-content-between my-3">
            @if($page > 1)
                <form method="POST" action="{{ route('mailbox.connect') }}">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    <input type="hidden" name="password" value="{{ request('password') }}">
                    <input type="hidden" name="page" value="{{ $page - 1 }}">
                    <button type="submit" class="btn btn-outline-primary">Previous</button>
                </form>
            @else
                <span></span>
            @endif

            <span>Page {{ $page }} of {{ $total_pages }}</span>

            @if($page < $total_pages)
                <form method="POST" action="{{ route('mailbox.connect') }}">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    <input type="hidden" name="password" value="{{ request('password') }}">
                    <input type="hidden" name="page" value="{{ $page + 1 }}">
                    <button type="submit" class="btn btn-outline-primary">Next</button>
                </form>
            @else
                <span></span>
            @endif
        </div>

        <div class="row">
            <div class="col-md-5">
                <div class="list-group">
                    @forelse($messages as $message)
                        @php
                            $from = $message['from'];
                            if (preg_match('/<(.+)>/', $from, $matches)) {
                                $from = $matches[1];
                            }
                        @endphp
                        <a href="#" class="list-group-item list-group-item-action email-item"
                            data-subject="{{ $message['subject'] ?? 'No Subject' }}"
                            data-from="{{ $message['from'] ?? 'Unknown' }}"
                            data-date="{{ $message['date'] ?? 'No Date' }}"
                            data-body="{{ htmlspecialchars($message['body'] ?? '') }}"
                        >
                            <div class="fw-bold">{{ $message['subject'] ?? 'No Subject' }}</div>
                            <small class="text-muted">From: {{ $from }}</small><br>
                            <small class="text-muted">Date: {{ $message['date'] ?? 'No Date' }}</small>
                        </a>
                    @empty
                        <div class="alert alert-info">No emails to display.</div>
                    @endforelse
                </div>
            </div>

            <div class="col-md-7">
                <div class="email-preview p-3 border rounded" style="min-height: 400px;">
                    <h4 id="email-subject">Select an email</h4>
                    <div id="email-from" class="mb-2"></div>
                    <div id="email-date" class="mb-2"></div>
                    <div id="email-body" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.email-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const subject = this.getAttribute('data-subject');
                const from = this.getAttribute('data-from');
                const date = this.getAttribute('data-date');
                const body = this.getAttribute('data-body');

                document.getElementById('email-subject').innerText = subject;
                document.getElementById('email-from').innerText = 'From: ' + from;
                document.getElementById('email-date').innerText = 'Date: ' + date;

                // Decode HTML entities
                const temp = document.createElement('div');
                temp.innerHTML = body;
                document.getElementById('email-body').innerHTML = temp.textContent || temp.innerText;
            });
        });
    </script>
</body>
</html>
