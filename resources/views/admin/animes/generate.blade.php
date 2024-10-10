@extends('layouts.app')

@section('content')
    <div class="page-header">
        <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">{{ __('Generate Anime TMDB') }}</h2>
        </div>
    </div>

    <section>
        <div class="container-fluid">
            <div class="block">
                <div class="block-body">
                    @if (filled($apiKey))
                        <div class="form-group">
                            <label for="searchAnime">{{ __('Search Anime') }}</label>
                            <input type="text" class="form-control" id="searchAnime"
                                placeholder="{{ __('Enter anime title...') }}">
                        </div>

                        <div id="loading" class="text-center mt-4" style="display: none;">
                            <p>{{ __('Cargando animes...') }}</p>
                        </div>

                        <div id="resultsContainer" class="mt-4">
                            <table class="table table-hover" id="resultsTable" style="display: none;">
                                <thead>
                                    <tr>
                                        <th>{{ __('Image') }}</th>
                                        <th>{{ __('Title') }}</th>
                                        <th>{{ __('Overview') }}</th>
                                        <th>{{ __('Popularity') }}</th>
                                        <th>{{ __('Rating') }}</th>
                                        <th>{{ __('Votes') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="results">
                                    <!-- Aquí se insertarán los resultados -->
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-danger">
                            <strong>{{ __('Warning') }}!</strong>
                            {{ __('API Key no encontrada. Por favor, configúrala en los ajustes.') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        const API_KEY = '{{ $apiKey }}';
        const BASE_URL = 'https://api.themoviedb.org/3/search/tv';

        if (!API_KEY) {
            alert('API Key no está configurada. Por favor, configúrala en los ajustes.');
            throw new Error('API Key no configurada');
        }

        let timeout = null;

        document.getElementById('searchAnime').addEventListener('input', function() {

            clearTimeout(timeout);

            document.getElementById('loading').style.display = 'block';
            document.getElementById('resultsTable').style.display = 'none';

            timeout = setTimeout(function() {
                const query = document.getElementById('searchAnime').value;

                if (query.trim() === '') {
                    document.getElementById('loading').style.display = 'none';
                    return;
                }

                const options = {
                    method: 'GET',
                    headers: {
                        accept: 'application/json',
                        Authorization: `Bearer ${API_KEY}`,
                    }
                };

                fetch(`${BASE_URL}?query=${encodeURIComponent(query)}&include_adult=false&language=es-MX&page=1`,
                        options)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('loading').style.display = 'none';

                        const resultsContainer = document.getElementById('results');
                        resultsContainer.innerHTML = '';

                        if (data.results && data.results.length > 0) {
                            document.getElementById('resultsTable').style.display = 'table';

                            data.results.forEach(anime => {
                                const animeRow = `
                                    <tr>
                                        <td>
                                            <a href="https://image.tmdb.org/t/p/original${anime.poster_path}" target="_blank">
                                                <img src="https://image.tmdb.org/t/p/w200${anime.poster_path}" alt="${anime.name}" class="img-fluid" style="max-width: 100px;">
                                            </a>
                                        </td>
                                        <td>${anime.name} (${anime.first_air_date})</td>
                                        <td>${anime.overview}</td>
                                        <td>${anime.popularity}</td>
                                        <td>${anime.vote_average} / 10</td>
                                        <td>${anime.vote_count}</td>
                                        <td>
                                            <form action="{{ route('admin.animes.storeTmdb') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="name" value="${anime.name}">
                                                <input type="hidden" name="original_name" value="${anime.original_name}">
                                                <input type="hidden" name="overview" value="${anime.overview}">
                                                <input type="hidden" name="popularity" value="${anime.popularity}">
                                                <input type="hidden" name="poster_path" value="${anime.poster_path}">
                                                <input type="hidden" name="backdrop_path" value="${anime.backdrop_path}">
                                                <input type="hidden" name="first_air_date" value="${anime.first_air_date}">
                                                <input type="hidden" name="vote_average" value="${anime.vote_average}">
                                                <input type="hidden" name="vote_count" value="${anime.vote_count}">
                                                <button type="submit" class="btn btn-success">{{ __('Guardar') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                `;
                                resultsContainer.innerHTML += animeRow;
                            });
                        } else {
                            resultsContainer.innerHTML =
                                '<tr><td colspan="7">{{ __('No se encontraron resultados.') }}</td></tr>';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        document.getElementById('loading').style.display = 'none';
                        alert(
                            'Hubo un error al consultar la API. Revisa la consola para más detalles.'
                            );
                    });
            }, 500);
        });
    </script>
@endpush
