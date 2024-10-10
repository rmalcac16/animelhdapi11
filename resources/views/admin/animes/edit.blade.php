@extends('layouts.app')

@section('content')
    <div class="page-header">
        <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">{{ __('Edit Anime') }}</h2>
        </div>
    </div>

    <section>
        <div class="container-fluid">
            <div class="block">
                <div class="d-flex justify-content-between">
                    <div class="title">
                        <strong>{{ __('Edit Anime') }}</strong>
                    </div>
                    <div>
                        @if (filled($apiKey))
                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#generateData">
                                <i class="fa fa-fw fa-magic"></i>
                                {{ __('Generate') }}
                            </button>
                        @endif
                    </div>
                </div>

                <div class="block-body">

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ __('Error!') }}</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('admin.animes.update', $anime->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-7">
                                <div class="form-group">
                                    <label for="name" class="form-control-label">{{ __('Name') }}</label>
                                    <input type="text" id="name" name="name" class="form-control"
                                        value="{{ old('name', $anime->name) }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="name_alternative"
                                        class="form-control-label">{{ __('Name Alternative') }}</label>
                                    <input type="text" id="name_alternative" name="name_alternative"
                                        data-role="tagsinput"
                                        value="{{ old('name_alternative', $anime->name_alternative) }}">
                                </div>

                                <div class="form-group">
                                    <label for="slug" class="form-control-label">{{ __('Slug') }}</label>
                                    <input type="text" id="slug" name="slug" class="form-control"
                                        value="{{ old('slug', $anime->slug) }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="overview" class="form-control-label">{{ __('Overview') }}</label>
                                    <textarea id="overview" name="overview" class="form-control" rows="5">{{ old('overview', $anime->overview) }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="genres" class="form-control-label">{{ __('Genres') }}</label>
                                    <select id="genres" name="genres[]" class="form-control js-select-genres-multiple"
                                        multiple="multiple">
                                        @foreach ($genres as $genre)
                                            <option value="{{ $genre->slug }}"
                                                {{ in_array($genre->slug, explode(',', strtolower($anime->genres))) ? 'selected' : '' }}>
                                                {{ $genre->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="related" class="form-control-label">{{ __('Related') }}</label>
                                    <input type="text" id="related" name="related" data-role="tagsinput"
                                        value="{{ old('related', $anime->related) }}">
                                </div>

                            </div>

                            <div class="col-md-5">
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="type" class="form-control-label">{{ __('Type') }}</label>
                                            <select class="form-control" name="type" id="type">
                                                <option value="TV"
                                                    {{ old('type', $anime->type) == 'TV' ? 'selected' : '' }}>
                                                    {{ __('Anime') }}</option>
                                                <option value="Movie"
                                                    {{ old('type', $anime->type) == 'Movie' ? 'selected' : '' }}>
                                                    {{ __('Movie') }}</option>
                                                <option value="OVA"
                                                    {{ old('type', $anime->type) == 'OVA' ? 'selected' : '' }}>
                                                    {{ __('OVA') }}</option>
                                                <option value="ONA"
                                                    {{ old('type', $anime->type) == 'ONA' ? 'selected' : '' }}>
                                                    {{ __('ONA') }}</option>
                                                <option value="Special"
                                                    {{ old('type', $anime->type) == 'Special' ? 'selected' : '' }}>
                                                    {{ __('Special') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="status" class="form-control-label">{{ __('Status') }}</label>
                                            <select class="form-control" name="status" id="status">
                                                <option value="1"
                                                    {{ old('status', $anime->status) == 1 ? 'selected' : '' }}>
                                                    {{ __('On Going') }}</option>
                                                <option value="0"
                                                    {{ old('status', $anime->status) == 0 ? 'selected' : '' }}>
                                                    {{ __('Finished') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="poster" class="form-control-label">{{ __('Poster') }}</label>
                                    <input type="text" id="poster" name="poster" class="form-control"
                                        value="{{ old('poster', $anime->poster) }}">
                                </div>
                                <div class="form-group">
                                    <label for="banner" class="form-control-label">{{ __('Banner') }}</label>
                                    <input type="text" id="banner" name="banner" class="form-control"
                                        value="{{ old('banner', $anime->banner) }}">
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="aired" class="form-control-label">{{ __('Aired') }}</label>
                                            <input type="date" id="aired" name="aired" class="form-control"
                                                value="{{ old('aired', $anime->aired) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="premiered"
                                                class="form-control-label">{{ __('Premiered') }}</label>
                                            <input type="text" id="premiered" name="premiered" class="form-control"
                                                value="{{ old('premiered', $anime->premiered) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="rating" class="form-control-label">{{ __('Rating') }}</label>
                                    <input type="text" id="rating" name="rating" class="form-control"
                                        value="{{ old('rating', $anime->rating) }}">
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="form-group">
                                            <label for="popularity"
                                                class="form-control-label">{{ __('Popularity') }}</label>
                                            <input type="number" min="0" id="popularity" name="popularity"
                                                class="form-control" value="{{ old('popularity', $anime->popularity) }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="form-group">
                                            <label for="vote_average"
                                                class="form-control-label">{{ __('Vote Average') }}</label>
                                            <input type="number" min="0" step=".01" id="vote_average"
                                                name="vote_average" class="form-control"
                                                value="{{ old('vote_average', $anime->vote_average) }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="form-group">
                                            <label for="broadcast"
                                                class="form-control-label">{{ __('Broadcast') }}</label>
                                            <select class="form-control" name="broadcast" id="broadcast">
                                                <option value="1"
                                                    {{ old('broadcast', $anime->broadcast) == 1 ? 'selected' : '' }}>
                                                    {{ __('Monday') }}</option>
                                                <option value="2"
                                                    {{ old('broadcast', $anime->broadcast) == 2 ? 'selected' : '' }}>
                                                    {{ __('Tuesday') }}</option>
                                                <option value="3"
                                                    {{ old('broadcast', $anime->broadcast) == 3 ? 'selected' : '' }}>
                                                    {{ __('Wednesday') }}</option>
                                                <option value="4"
                                                    {{ old('broadcast', $anime->broadcast) == 4 ? 'selected' : '' }}>
                                                    {{ __('Thursday') }}</option>
                                                <option value="5"
                                                    {{ old('broadcast', $anime->broadcast) == 5 ? 'selected' : '' }}>
                                                    {{ __('Friday') }}</option>
                                                <option value="6"
                                                    {{ old('broadcast', $anime->broadcast) == 6 ? 'selected' : '' }}>
                                                    {{ __('Saturday') }}</option>
                                                <option value="7"
                                                    {{ old('broadcast', $anime->broadcast) == 7 ? 'selected' : '' }}>
                                                    {{ __('Sunday') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="prequel" class="form-control-label">{{ __('Prequel') }}</label>
                                            <input type="number" min="1" id="prequel" name="prequel"
                                                class="form-control" value="{{ old('prequel', $anime->prequel) }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="form-group">
                                            <label for="sequel" class="form-control-label">{{ __('Sequel') }}</label>
                                            <input type="number" min="1" id="sequel" name="sequel"
                                                class="form-control" value="{{ old('sequel', $anime->sequel) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">{{ __('Update Anime') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="generateData" tabindex="-1" role="dialog" aria-labelledby="generateDataLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="generateDataLabel">{{ __('Consult Anime') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-inline">
                        <div class="form-group">
                            <label for="manualAnimeId" class="sr-only">{{ __('Enter Anime ID') }}</label>
                            <input type="text" id="manualAnimeId" class="mr-sm-3 form-control"
                                placeholder="{{ __('Anime ID') }}">
                        </div>
                        <div class="form-group">
                            <button type="button" id="fetchAnimeById"
                                class="btn btn-primary">{{ __('Fetch') }}</button>
                        </div>
                    </div>
                    <hr>
                    <div id="animeDataContainer"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>


@endsection

@push('styles')
    <!-- Select2 CSS-->
    <link href="{{ asset('assets/admin/css/select2.min.css') }}" rel="stylesheet" />
    <!-- Bootstrap Tags input CSS-->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/bootstrap-tagsinput.css') }}">
@endpush

@push('scripts')
    <!-- Select2 JS-->
    <script src="{{ asset('assets/admin/js/select2.min.js') }}"></script>
    <!-- Bootstrap Tags Input-->
    <script src="{{ asset('assets/admin/js/bootstrap-tagsinput.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $(document).ready(function() {
                $('.js-select-genres-multiple').select2();
            });

            document.querySelector('#fetchAnimeById').addEventListener('click', function() {
                const animeId = document.querySelector('#manualAnimeId').value;
                if (animeId) {
                    fetchAnimeDataById(animeId);
                } else {
                    alert('{{ __('Please enter a valid Anime ID') }}');
                }
            });

            $('#generateData').on('show.bs.modal', function() {
                const animeName = document.querySelector('#name').value;

                fetch(`{{ route('admin.animes.fetchanimedata') }}?q=${encodeURIComponent(animeName)}`)
                    .then(response => response.json())
                    .then(data => {
                        let animeDataContainer = document.querySelector('#animeDataContainer');
                        animeDataContainer.innerHTML = '';

                        if (data.error) {
                            animeDataContainer.innerHTML =
                                '<p>{{ __('There was an error fetching anime data.') }}</p>';
                        } else {
                            let animeRow = document.createElement('div');
                            animeRow.classList.add('row');

                            data.data.forEach(item => {
                                let anime = item.node;

                                let col = document.createElement('div');
                                col.classList.add('col-12', 'col-md-6', 'col-lg-3', 'mb-4');

                                let card = document.createElement('div');
                                card.classList.add('card', 'text-white', 'mb-0');
                                card.setAttribute('data-id', anime.id);

                                let cardImage = document.createElement('img');
                                cardImage.src = anime.main_picture.medium;
                                cardImage.classList.add('card-img', 'fixed-height');

                                let overlay = document.createElement('div');
                                overlay.classList.add('card-img-overlay', 'd-flex',
                                    'align-items-end', 'p-0');

                                let title = document.createElement('p');
                                title.classList.add('card-title', 'bg-dark', 'bg-opacity-75',
                                    'text-center', 'w-100', 'm-0', 'p-2', 'line-clamp-2');
                                title.textContent = anime.title;

                                overlay.appendChild(title);

                                let mediaTypeBadge = document.createElement('span');
                                mediaTypeBadge.classList.add('badge', 'bg-primary',
                                    'position-absolute', 'top-0', 'start-0', 'm-2');
                                mediaTypeBadge.textContent = anime.media_type
                                    .toUpperCase();

                                let yearBadge = document.createElement('span');
                                yearBadge.classList.add('badge', 'bg-secondary',
                                    'position-absolute', 'top-0', 'end-0', 'm-2');

                                let startDate = new Date(anime.start_date);
                                let year = startDate.getFullYear();
                                yearBadge.textContent = year;
                                card.appendChild(mediaTypeBadge);
                                card.appendChild(yearBadge);
                                card.appendChild(cardImage);
                                card.appendChild(overlay);
                                col.appendChild(card);
                                animeRow.appendChild(col);

                                card.addEventListener('click', function() {
                                    const animeId = this.getAttribute('data-id');
                                    fetchAnimeDataById(animeId);
                                });
                            });

                            animeDataContainer.appendChild(animeRow);
                        }
                    })
                    .catch(error => {
                        let animeDataContainer = document.querySelector('#animeDataContainer');
                        animeDataContainer.innerHTML =
                            '<p>{{ __('There was an error fetching anime data.') }}</p>';
                    });
            });

            let mediaTypeDb = [
                [
                    ["tv", "TV"]
                ],
                [
                    ["movie", "Movie"]
                ],
                [
                    ["ova", "OVA"]
                ],
                [
                    ["ona", "ONA"]
                ],
                [
                    ["special", "Special"]
                ]
            ]

            let ratingDB = [
                [
                    ["g", "Todas las edades"]
                ],
                [
                    ["pg", "Niños"]
                ],
                [
                    ["pg_13", "Adolescentes de 13 años o más"]
                ],
                [
                    ["r", "Adolescentes de 17 años o más (Violencia)"]
                ],
                [
                    ["r+", "Solo adultos (Desnudos)"]
                ],
                [
                    ["rx", "No se permiten niños"]
                ]
            ];
            let broadcastDB = [
                [
                    ["monday", 1]
                ],
                [
                    ["tuesday", 2]
                ],
                [
                    ["wednesday", 3]
                ],
                [
                    ["thursday", 4]
                ],
                [
                    ["friday", 5]
                ],
                [
                    ["saturday", 6]
                ],
                [
                    ["sunday", 7]
                ]
            ];
            let genresDB = [
                [
                    ["Action", "accion"]
                ],
                [
                    ["Adventure", "aventura"]
                ],
                [
                    ["Comedy", "comedia"]
                ],
                [
                    ["Detective", "detectives"]
                ],
                [
                    ["Drama", "drama"]
                ],
                [
                    ["Ecchi", "ecchi"]
                ],
                [
                    ["Fantasy", "fantasia"]
                ],
                [
                    ["Gore", "gore"]
                ],
                [
                    ["Harem", "harem"]
                ],
                [
                    ["Historical", "historico"]
                ],
                [
                    ["Horror", "horror"]
                ],
                [
                    ["Isekai", "isekai"]
                ],
                [
                    ["Josei", "josei"]
                ],
                [
                    ["Mahou Shoujo", "mahou-shoujo"]
                ],
                [
                    ["Martial Arts", "artes-marciales"]
                ],
                [
                    ["Mecha", "mecha"]
                ],
                [
                    ["Military", "militar"]
                ],
                [
                    ["Mythology", "mitologico"]
                ],
                [
                    ["Music", "musica"]
                ],
                [
                    ["Mystery", "misterio"]
                ],
                [
                    ["Parody", "parodia"]
                ],
                [
                    ["Psychological", "psicologico"]
                ],
                [
                    ["Romance", "romance"]
                ],
                [
                    ["Romantic Subtext", "romance"]
                ],
                [
                    ["Samurai", "samurais"]
                ],
                [
                    ["School", "escolar"]
                ],
                [
                    ["Sci-Fi", "ciencia-ficcion"]
                ],
                [
                    ["Seinen", "seinen"]
                ],
                [
                    ["Shoujo", "shoujo"]
                ],
                [
                    ["Girls Love", "shoujo-ai"]
                ],
                [
                    ["Shounen", "shounen"]
                ],
                [
                    ["Hentai", "soft-hentai"]
                ],
                [
                    ["Boys Love", "shounen-ai"]
                ],
                [
                    ["Slice of Life", "recuentos-de-la-vida"]
                ],
                [
                    ["Space", "espacio"]
                ],
                [
                    ["Sports", "deportes"]
                ],
                [
                    ["Super Power", "super-poderes"]
                ],
                [
                    ["Supernatural", "sobrenatural"]
                ],
                [
                    ["Suspense", "suspenso"]
                ],
                [
                    ["Vampire", "vampiros"]
                ],
                [
                    ["Video Game", "juegos"]
                ]
            ];

            function mapRating(malRating) {
                let mappedRating = '';
                ratingDB.forEach(function(item) {
                    if (item[0][0] === malRating) {
                        mappedRating = item[0][1];
                    }
                });
                return mappedRating;
            }

            function mapGenres(malGenres) {
                let mappedGenres = [];
                malGenres.forEach(function(genre) {
                    genresDB.forEach(function(item) {
                        if (item[0][0].toLowerCase() === genre.name.toLowerCase()) {
                            mappedGenres.push(item[0][1]);
                        }
                    });
                });
                return mappedGenres;
            }

            function mapDays(malBroadcast) {
                let mappedDays = '';
                broadcastDB.forEach(function(item) {
                    if (item[0][0] === malBroadcast) {
                        mappedDays = item[0][1];
                    }
                });
                return mappedDays;
            }

            function mapMediaType(malType) {
                let mappedType = '';
                mediaTypeDb.forEach(function(item) {
                    if (item[0][0] === malType) {
                        mappedType = item[0][1];
                    }
                });
                return mappedType;
            }

            function getAlternativeNames(alternativeTitles) {
                let nameAlternative = [];
                if (alternativeTitles.synonyms && alternativeTitles.synonyms.length > 0) {
                    nameAlternative = nameAlternative.concat(alternativeTitles.synonyms);
                }
                if (alternativeTitles.en) {
                    nameAlternative.push(alternativeTitles.en);
                }
                if (alternativeTitles.ja) {
                    nameAlternative.push(alternativeTitles.ja);
                }
                return nameAlternative;
            }

            function fetchAnimeDataById(animeId) {
                fetch(`{{ route('admin.animes.fetchanimedataid') }}?id=${animeId}`)
                    .then(response => response.json())
                    .then(data => {
                        document.querySelector('#name').value = data.title || '';
                        $('#name_alternative').tagsinput('removeAll');
                        const alternativeNames = getAlternativeNames(data.alternative_titles);
                        alternativeNames.forEach(function(name) {
                            $('#name_alternative').tagsinput('add', name);
                        });
                        document.querySelector('#rating').value = mapRating(data.rating) ||
                            '';
                        document.querySelector('#type').value = mapMediaType(data.media_type) || '';
                        if (data.status) {
                            document.querySelector('#status').value = data.status == 'finished_airing' ? 0 :
                                1 || '';
                        }
                        if (data.broadcast && data.broadcast.day_of_the_week) {
                            document.querySelector('#broadcast').value = mapDays(data.broadcast
                                .day_of_the_week) || '';
                        }
                        document.querySelector('#popularity').value = data.popularity || '';
                        document.querySelector('#vote_average').value = data.mean || '';
                        document.querySelector('#aired').value = data.start_date || '';
                        const genres = mapGenres(data.genres);
                        $('#genres').val(genres).trigger('change');
                        $('#generateData').modal('hide');
                    })
                    .catch(error => {
                        console.error('Error fetching anime by ID:', error);
                    });
            }
        });
    </script>
@endpush
