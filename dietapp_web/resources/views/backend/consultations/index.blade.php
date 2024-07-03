@extends('layouts.backend.main')

@section('title', 'Konsultasi')

@section('css')
<!-- Emojionearea -->
<link rel="stylesheet" href="{{ asset('backend') }}/libs/emojionearea/dist/emojionearea.min.css"/>
@endsection

@section('content')
<div class="container-fluid">
    <div class="layout-specing">
        <div class="d-md-flex justify-content-between align-items-center">
            <h5 class="mb-0">Konsultasi</h5>

            <nav aria-label="breadcrumb" class="d-inline-block">
                <ul class="breadcrumb bg-transparent rounded mb-0 p-0">
                    <li class="breadcrumb-item text-capitalize"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item text-capitalize active" aria-current="page">Konsultasi</li>
                </ul>
            </nav>
        </div>

        <div class="row g-2">
            <div class="col-xl-4 col-lg-5 col-md-5 col-12 mt-4">
                <div class="card border-0 rounded shadow">
                    <div class="text-center p-4 border-bottom">
                        @if (Auth::user()->image == 'default/user.png')
                            <img src="{{ asset(Auth::user()->image) }}" class="avatar avatar-md-md rounded-pill shadow" alt="avatar">
                        @else
                            <img src="{{ asset('storage/users/' . Auth::user()->image) }}" class="avatar avatar-md-md rounded-pill shadow" alt="avatar">
                        @endif
                        <h5 class="mt-3 mb-0">{{ Auth::user()->name }}</h5>
                        <p class="text-muted mb-0"><small class="text-muted">{{ Auth::user()->hasRole('admin') ? 'Administrator' : 'Customer Service' }}</small></p>
                        <button type="button" class="btn btn-primary btn-sm new-chat"><i class="fa-solid fa-plus"></i> Obrolan baru</button>
                    </div>

                    <div class="container">
                        <div class="p-2 chat chat-list mt-2" id="list" data-simplebar style="height: 220px; max-height: 100%; overflow-y: auto;"></div>
                    </div>
                </div>
            </div><!--end col-->

            <div class="col-xl-8 col-lg-7 col-md-7 col-12 mt-4" id="chat-person">
                <p class="d-flex text-muted justify-content-center align-items-center" style="height: 100%;">Pilih pengguna untuk mulai mengobrol.</p>
            </div><!--end col-->
        </div><!--end row-->
    </div>
</div><!--end container-->

<div class="viewModal" style="display: none;"></div>
@endsection

@section('javascript')
<!-- Emojionearea -->
<script src="{{ asset('backend') }}/libs/emojionearea/dist/emojionearea.min.js"></script>
<script>
    $(document).ready(function() {
        listChat();

        $('.new-chat').click(function() {
            $.ajax({
                url: "{{ route('consultations.new') }}",
                dataType: "json",
                success: function(response) {
                    $('.viewModal').html(response.listUser).show();
                    $('#add-modal').modal('show');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });

    // Function to load chat data
    function loadChatData() {
        setInterval(function() {
            $.ajax({
                url: "{{ route('consultations.list') }}",
                dataType: "json",
                success: function(response) {
                    $('#list').html(response.listView);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        }, 5000);
    }

    function listChat()
    {
        $.ajax({
            url: "{{ route('consultations.list') }}",
            dataType: "json",
            success: function(response) {
                $('#list').html(response.listView);

                loadChatData();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function startChatPolling(userId) {
        setInterval(function() {
            $.ajax({
                url: "{{ route('consultations.content', ':id') }}".replace(':id', userId),
                dataType: "json",
                success: function(response) {
                    // Compare the received chat content with the current chat content
                    var currentContent = $('#chat-ul').html();
                    if (response.content !== currentContent) {
                        // If there is an update, update the chat content and scroll down
                        $('#chat-ul').html(response.content);
                        var contentChat = $(".content-chat")[0];
                        contentChat.scrollTop = contentChat.scrollHeight - contentChat.clientHeight;
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        }, 5000);
    }

    function contentChat(userId) {
        $.ajax({
            url: "{{ route('consultations.content', ':id') }}".replace(':id', userId),
            dataType: "json",
            success: function(response) {
                $('#chat-ul').html(response.content);

                // Scroll to the bottom of .content-chat
                var contentChat = $(".content-chat")[0];
                contentChat.scrollTop = contentChat.scrollHeight - contentChat.clientHeight;

                // Start polling to check for updates every few seconds (for example, 5 seconds)
                startChatPolling(userId);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    function showUserInfo(userId, event) {
        event.preventDefault(); // Prevent default link behavior

        $('#add-modal').modal('hide');

        const url = "{{ route('consultations.person', ':id') }}";
        const redirectUrl = url.replace(':id', userId);

        $.ajax({
            url: redirectUrl,
            type: "GET",
            dataType: "html", // Change the data type as needed
            success: function(response) {
                // Get the chat-person element and update its content
                const chatPersonElement = document.getElementById("chat-person");
                chatPersonElement.innerHTML = response;

                // Initialize Emoji One Area
                let emojiArea = $("#chat-message").emojioneArea({
                    search: false,
                    tones: false,
                    events: {
                        keyup: function(button, e) {
                            if (e.keyCode == 13 && !e.shiftKey) {
                                let message = this.getText();
                                if (message.trim() !== '') {
                                    send(message);
                                    this.setText('');
                                }
                            }
                        }
                    }
                });

                $('#send-message').click(function(e) {
                    e.preventDefault();
                    let message = emojiArea[0].emojioneArea.getText();
                    if (message.trim() !== '') {
                        send(message);
                        emojiArea[0].emojioneArea.setText('');
                    }
                });

                contentChat(userId);
                listChat();

                $('#delete-all').click(function() {
                    var senderId = $(this).data('sender-id');
                    var recipient = $("#recipient").val();

                    $.ajax({
                        url: "{{ route('consultations.delete-all') }}",
                        type: "POST",
                        data: {
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                            sender_id: senderId,
                            recipient: recipient,
                        },
                        success: function(response) {
                            $('#chat-ul').empty();
                            listChat();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus, errorThrown);
                        }
                    });
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }

    function send(message) {
        var recipient = $("#recipient").val();

        $.ajax({
            url: "{{ route('consultations.send') }}",
            type: "POST",
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                recipient: recipient,
                message: message,
            },
            dataType: "json",
            success: function(response) {
                contentChat(recipient);

                const chatLinks = document.querySelectorAll('.chat-list');
                chatLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('data-id') === recipient) {
                        link.classList.add('active');
                    }
                });

                listChat();
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    function attachment(input) {
        var fileInput = input;
        var file = fileInput.files[0];

        if (attachment) {
            var formData = new FormData();
            formData.append("attachment", fileInput.files[0]);

            var recipient = $("#recipient").val();

            formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
            formData.append("recipient", recipient);

            $.ajax({
                url: "{{ route('consultations.attachment') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    contentChat(recipient);

                    const chatLinks = document.querySelectorAll('.chat-list');
                    chatLinks.forEach(link => {
                        link.classList.remove('active');
                        if (link.getAttribute('data-id') === recipient) {
                            link.classList.add('active');
                        }
                    });

                    listChat();
                },
                error: function(xhr, status, error) {
                    console.error("Terjadi kesalahan saat mengunggah file: " + error);
                }
            });
        }
    };
</script>
@endsection
