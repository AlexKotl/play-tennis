@extends('layouts.app')

@section('site_title')
    @empty($user)
        Реєстрація профіля теннисиста
    @else
        Профіль
    @endif
@endsection

@section('breadcrumbs')
    @empty($user)
        <a href="">Реєстрація</a>
    @else
        <a href="">Профіль гравця</a>
    @endif
@endsection

@section('content')
    <script>
        $(function() {
            // init phone mask
            $('.phone_mask').mask("(0__) ___ __ __", {
                placeholder: "(0__) ___ __ __",
                translation: {
                    0: null, 9: null, '_': {pattern: /\d/, optional: false}
                }
            });

            // hide map for mobile devices
            if ($(window).width() <= 576) {
                $('#collapse_map').removeClass('show');
            }

            $('.is-trainer-row input').change(function() {
                $('.trainer-price').toggleClass('d-none');
            });
        })
    </script>

    @empty($user)
        <h1>Реєстрація</h1>
    @else
        <h1>Ваш профіль</h1>
    @endif

    <form method="post" enctype="multipart/form-data">
        @csrf

        <div class="form-group row">
            <label class="col-md-3 col-form-label">Імʼя</label>
            <div class="col-md-9">
                {{Form::text('name', isset($user) ? $user->name : '', ['class' => 'form-control', 'autofocus' => 'autofocus'])}}
                <small class="form-text text-muted">Ваше повне імʼя, яке буде відображатися на сайті</small>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-3 col-form-label">Телефон</label>
            <div class="col-md-9">
                {{Form::text('phone', isset($user) ? $user->phone : '', ['class' => 'form-control phone_mask'])}}
                <small class="form-text text-muted">Телефон будуть бачити лише ваші друзі</small>
            </div>
        </div>

        @empty($user)
            <div class="form-group row">
                <label class="col-md-3 col-form-label">Email</label>
                <div class="col-md-9">
                    {{Form::text('email', '', ['class' => 'form-control'])}}
                </div>
            </div>
        @endif

        <div class="form-group row">
            <label class="col-md-3 col-form-label">Корти</label>
            <div class="col-md-9">
                <p>
                    <small class="form-text text-muted">
                        Виберіть корти, на котрих ви можете грати на карті або віберіть зі списку нижче:
                    </small>
                </p>

                <a class="btn btn-primary d-sm-none" data-toggle="collapse" href="#collapse_map">
                    <i class="fa fa-map"></i> Показати карту
                </a>
                <div id="collapse_map" class="collapse show">
                    <div id="map" class="map" style="width:100%; height:400px"></div>
                </div>

                <script type="text/javascript">
                    var map = L.map('map').setView([50.4425, 30.5133], 12);

                    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution:'Map data <a target="_blank" href="http://www.openstreetmap.org">OpenStreetMap.org</a> contributors, ' +
                            '<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
                        maxZoom: 18,
                    }).addTo(map);

                    var MarkerIcon = L.Icon.extend({
                        options: {
                            iconSize: [25, 41],
                            iconAnchor: [13, 41],
                            popupAnchor: [0, -41]
                        }
                    });
                    var IconSelected = new MarkerIcon({iconUrl: '/images/icons/map-marker-ball.png'});
                    var Icon = new MarkerIcon({iconUrl: '/images/icons/map-marker.png'});
                    var markers = [];

                    @foreach ($courts as $court)
                        @if ($court->map_lat != 0 && $court->map_lng != 0)
                            var marker = L.marker([{{ $court->map_lat }}, {{ $court->map_lng }}], {
                                icon: @if (isset($courts_checked) && in_array($court->id, $courts_checked)) IconSelected @else Icon @endif
                            }).addTo(map);
                            marker.bindPopup("<b>{{ $court->name }}</b>");
                            marker.isSelected = false;
                            marker.courtId = {{ $court->id }};
                            marker.on('click', function(element) {
                                var is_selected = element.target.isSelected;
                                element.target.isSelected = !is_selected;
                                element.target.setIcon(is_selected ? Icon : IconSelected);
                                $('input.court_checkbox[value={{ $court->id }}]').prop('checked', !is_selected);
                            });

                            markers['{{ $court->id }}'] = marker;
                        @endif
                    @endforeach

                    $(document).ready(function() {
                        $('input.court_checkbox').on('change', function(element) {
                            if (markers[$(this).val()] !== undefined) {
                                markers[$(this).val()].fire('click');
                            }
                        });
                    })

                </script>

                <div class="row" style="padding-left:15px; padding-top: 15px">
                    @foreach ($courts as $court)
                        <div class="form-check col-12 col-sm-4">
                            <label class="form-check-label">
                                <input class="court_checkbox form-check-input" name="courts[]" type="checkbox"
                                    value="{{ $court->id }}" @if (isset($courts_checked) && in_array($court->id, $courts_checked)) checked @endif />
                                {{ $court->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-3 col-form-label">Рівень гри</label>
            <div class="col-md-9">
                {{Form::select('rank', $ranks, isset($user) ? $user->rank : '', ['class' => 'form-control'])}}
                <small class="form-text text-muted">
                    <a href="#" data-toggle="modal" data-target="#rankModal">
                        Як визначити свій рівень?
                    </a>
                </small>
            </div>
        </div>

        <div class="form-group row is-trainer-row">
            <label class="col-md-3 col-form-label">Тренер?</label>
            <div class="col-md-9">
                <label>
                    {{Form::checkbox('is_trainer', true, isset($user) ? $user->is_trainer : false)}}
                    Я надаю  <b>тренерські</b> послуги<br>
                    <small>
                        Якщо ви навчаєте інших гравців - поставте цю галочку і ваш профіль зʼявиться у розділі тренерів. 
                        Детальну інформацію про тренування можете вказати в полі "Про мене".
                    </small>
                </label>
            </div>
        </div>

        <div class="form-group row trainer-price {{ isset($user) && $user->is_trainer ? '' : 'd-none' }}">
            <label class="col-md-3 col-form-label">
                Ціна тренування
                <small>(грн)</small>
            </label>
            <div class="col-md-9">
                {{Form::number('trainer_price', isset($user) ? $user->trainer_price : '', ['class' => 'form-control'])}}
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-3 col-form-label">Досвід гри</label>
            <div class="col-md-9">
                {{Form::select('player_since', $years, isset($user) ? $user->player_since : '', ['class' => 'form-control'])}}
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-3 col-form-label">Про мене</label>
            <div class="col-md-9">
                <textarea name="about" cols="10" rows="4" class="form-control" placeholder="О себе"
                    title="Расскажите о себе, ваш опыт игры, увлечения и т.д." id="id_about"
                    >@isset($user){{$user->about}}@endisset</textarea>
                <small class="form-text text-muted">
                    Розкажіть про себе, ваш досвід гри, хоббі і т.д.
                </small>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-3 col-form-label">Фото</label>
            <div class="col-md-9">
                @if (isset($user) && $user->avatar_image)
                    <p>
                        <img src="{{ asset('storage/avatars/'.$user->avatar_image) }}" width="200" alt="User photo">
                        &nbsp;
                        <label>
                            <input type="checkbox" name="image-clear" id="image-clear_id">
                            Видалити фото
                            <i class="fa fa-trash"></i>
                        </label>
                    </p>
                @endif

                <input type="file" name="avatar_image" accept="image/*">
            </div>
        </div>

        @empty($user)
            <div class="form-group row">
                <label class="col-md-3 col-form-label" for="id_password1">Пароль</label>
                <div class="col-md-9">
                    <input type="password" name="password" class="form-control" placeholder="Пароль" required="" autocomplete="new-password">
                    <small class="form-text text-muted">
                        <ul>
                            <li>Має бути не коротше 8 символів.</li>
                            <li>Має містити букви та числа.</li>
                        </ul>
                    </small>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3 col-form-label" for="id_password2">Пароль ще раз</label>
                <div class="col-md-9">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Пароль" required="" autocomplete="new-password">
                    <small class="form-text text-muted">Повторно введіть пароль.</small>
                </div>
            </div>
        @endif



        <input type="submit" value="@empty($user) Реєстрація @else Зберегти @endempty" class="btn btn-primary">
    </form>

    @include('inc.ranks_modal')


@endsection