@extends('livewire.components.main')
@section('content')
    <!-- Body-content -->
    <div class="body-content">
        <div class="container">
            <div class="page-header">
                <div>
                    <p>Todas as notificações</p>
                </div>
            </div>

            <div class="notification-section pb-15">
                @if (empty($notification))
                    <div class="notification-item">
                        <div class="notification-card">
                            <div class="notification-card-details">
                                <h3>Você não possui nenhuma notificação.</h3>
                                <p>{{ \Carbon\Carbon::today()->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>
                @endif
                    @foreach ($notification as $item)
                        <div class="notification-item">
                            <div class="notification-card">
                                <a id="readNotification{{ $item['id'] }}" href="#" data-bs-toggle="modal"
                                   data-bs-target="#notificationModal{{ $item['id'] }}">
                                    <div class="notification-card-thumb">
                                        <i class="{{ $item['icon'] }}"></i>
                                    </div>
                                    <div class="notification-card-details">
                                        @if ($item['status'] == false)
                                            <h7 class="text-success">Novo</h7>
                                        @endif
                                        <h3>{{ $item['title'] }}</h3>
                                        <p>{{ \Carbon\Carbon::today()->format('d/m/Y') }}</p>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="modal fade" id="notificationModal{{ $item['id'] }}" tabindex="-1"
                             aria-labelledby="notificationModal{{ $item['id'] }}" aria-hidden="true" data-bs-backdrop="static"
                             data-bs-keyboard="false">
                            <div class="modal-dialog modal-dialog-centered notification-modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('notification.put') }}" id="readNotificationForm{{ $item['id'] }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="notification_id" value="{{ $item['id'] }}">
                                        <div class="container">
                                            <div class="modal-header">
                                                <div class="modal-header-title">
                                                    <h5 class="modal-title">Detalhes da notificação</h5>
                                                </div>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                                        data-notification-id="{{ $item['id'] }}"></button>
                                                <!-- Adicionamos um atributo data-notification-id com o ID da notificação -->
                                            </div>
                                            <div class="modal-body">
                                                <div class="notification-modal">
                                                    <div class="notification-modal-header">
                                                        <h3>{{ $item['title'] }}</h3>
                                                        <p>{{ \Carbon\Carbon::parse($item['created_at'])->format('d/m/Y H:i:s') }}</p>
                                                    </div>
                                                    <div class="notification-modal-details">
                                                        {!! $item['body'] !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="notification-delete">
                                        <form action="{{ route('notification.delete') }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="notification_id" value="{{ $item['id'] }}">
                                            <button class="btn btn-danger">
                                                <i class="flaticon-trash text-white"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Incluir o script JavaScript fora do loop foreach -->
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                    <script>
                        $(document).ready(function() {
                            $('.btn-close').on('click', function() {
                                var notificationId = $(this).data('notification-id');
                                if (notificationId) {
                                    var actionUrl = $('#readNotificationForm' + notificationId).attr('action');
                                    var formData = new FormData($('#readNotificationForm' + notificationId)[0]);

                                    $.ajax({
                                        url: actionUrl,
                                        type: 'POST',
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        success: function(response) {
                                            console.log('Notificação marcada como lida');
                                            $('#notificationModal' + notificationId).modal('hide'); // Fecha o modal
                                            window.location.href = '/notification';
                                        },
                                        error: function(xhr, status, error) {
                                            console.error('Erro ao marcar notificação como lida');
                                        }
                                    });
                                }
                            });
                        });
                    </script>


            </div>
        </div>
    </div>
@endsection
