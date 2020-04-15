@extends('layouts.app')

@section('site_title')
    @empty($user)
        Регистрация профиля теннисиста
    @else
        Профиль
    @endif
@endsection

@section('breadcrumbs')
    @empty($user)
        <a href="">Регистрация</a>
    @else
        <a href="">Профиль игрока</a>
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
        })
    </script>

    @empty($user)
        <h1>Регистрация</h1>
    @else
        <h1>Ваш профиль</h1>
    @endif

    <form method="post" enctype="multipart/form-data">
        @csrf

        <div class="form-group row">
            <label class="col-md-3 col-form-label">Имя</label>
            <div class="col-md-9">
                {{Form::text('name', isset($user) ? $user->name : '', ['class' => 'form-control', 'autofocus' => 'autofocus'])}}
                <small class="form-text text-muted">Ваше полное имя, которое будет отображаться на сайте</small>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-3 col-form-label">Телефон</label>
            <div class="col-md-9">
                {{Form::text('phone', isset($user) ? $user->phone : '', ['class' => 'form-control phone_mask'])}}
                <small class="form-text text-muted">Телефон будет отображаться только для ваших друзей</small>
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
            <label class="col-md-3 col-form-label">Корты</label>
            <div class="col-md-9">
                <p>
                    <small class="form-text text-muted">Отметьте корты на которых вы можете играть на карте или выберите из списка ниже:</small>
                </p>

                <a class="btn btn-primary d-sm-none" data-toggle="collapse" href="#collapse_map">
                    <i class="fa fa-map"></i> Показать карту
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
                    var Icon = new MarkerIcon({iconUrl: 'images/icons/map-marker.png'});
                    var markers = [];

                    @foreach ($courts as $court)
                        @if ($court->map_lat != 0 && $court->map_lng != 0)
                            var marker = L.marker([{{ $court->map_lat }}, {{ $court->map_lng }}], {
                                icon: @if ($court->id == 0) IconSelected @else Icon @endif
                            }).addTo(map);
                            marker.bindPopup("<b>{{ $court->name }}</b>");
                            marker.isSelected = false;
                            marker.courtId = {{ $court->id }};
                            marker.on('click', function(element) {
                                var is_selected = element.target.isSelected;
                                element.target.isSelected = !is_selected;
                                element.target.setIcon(is_selected ? Icon : IconSelected);
                                $('input[name=courts][value={{ $court->id }}]').prop('checked', !is_selected);
                            });

                            markers['{{ $court->id }}'] = marker;
                        @endif
                    @endforeach

                    $(document).ready(function() {
                        $('input[name=courts]').on('change', function(element) {
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
                                <input class="form-check-input" name="courts" type="checkbox" value="{{ $court->id }}" @if ($court->id == 0) checked @endif />
                                {{ $court->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-3 col-form-label">Уровень игры</label>
            <div class="col-md-9">
                {{Form::select('rank', $ranks, isset($user) ? $user->rank : '', ['class' => 'form-control'])}}
                <small class="form-text text-muted"><a href="#" data-toggle="modal" data-target="#rankModal">Как определить свой уровень?</a></small>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-md-3 col-form-label">Игровой опыт</label>
            <div class="col-md-9">
                {{Form::select('player_since', $years, isset($user) ? $user->player_since : '', ['class' => 'form-control'])}}
            </div>
        </div>

        {{--
        <div class="form-group row">
            <label class="col-md-3 col-form-label" for="id_is_looking">&nbsp;</label>
            <div class="col-md-9">
                <div class="form-check">
                    <input type="checkbox" name="is_looking" class="form-check-input" id="id_is_looking" {% if form.is_looking.value == 1 %} checked {% endif %}>
                    <label class="form-check-label" for="id_is_looking" title="Отметьте галочку, если вы ищете партнера.">Ищу партнера</label>
                    <small class="form-text text-muted">Отметьте галочку, если вы ищете партнера.</small>
                </div>
            </div>
        </div>
        --}}

        <div class="form-group row">
            <label class="col-md-3 col-form-label">О себе</label>
            <div class="col-md-9">
                <textarea name="about" cols="10" rows="4" class="form-control" placeholder="О себе"
                    title="Расскажите о себе, ваш опыт игры, увлечения и т.д." id="id_about"
                    >@isset($user){{$user->about}}@endisset</textarea>
                <small class="form-text text-muted">Расскажите о себе, ваш опыт игры, увлечения и т.д.</small>
            </div>
        </div>

        {{--
        <div class="form-group row">
            <label class="col-md-3 col-form-label">Фото</label>
            <div class="col-md-9">
                {{ form.image.errors }}

                {% if form.image.value != null and form.image.value != '' %}
                    <p>
                        <img src="/media/{{ form.image.value }}" width="200" alt="User photo">
                        &nbsp;
                        <label>
                            <input type="checkbox" name="image-clear" id="image-clear_id">
                            Удалить фото
                            <i class="fa fa-trash"></i>
                        </label>
                    </p>
                {% endif %}


                <input type="file" name="image" accept="image/*">
            </div>
        </div>
        --}}

        @empty($user)
            <div class="form-group row">
                <label class="col-md-3 col-form-label" for="id_password1">Пароль</label>
                <div class="col-md-9">
                    <input type="password" name="password" class="form-control" placeholder="Пароль" required="" autocomplete="new-password">
                    <small class="form-text text-muted">
                        <ul>
                            <li>Должен содержать как минимум 8 символов.</li>
                            <li>Должен содержать буквы и числа.</li>
                        </ul>
                    </small>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3 col-form-label" for="id_password2">Пароль еще раз</label>
                <div class="col-md-9">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Пароль" required="" autocomplete="new-password">
                    <small class="form-text text-muted">Введите такой же пароль, как вы ввели выше.</small>
                </div>
            </div>
        @endif



        <input type="submit" value="Сохранить" class="btn btn-primary">
    </form>

    @include('inc.ranks_modal')


@endsection