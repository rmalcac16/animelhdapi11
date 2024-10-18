<div>
    <div class="page-header">
        <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">{{ __('Dashboard') }}</h2>
        </div>
    </div>
    <section class="no-padding-top no-padding-bottom">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="statistic-block block">
                        <div class="progress-details d-flex align-items-end justify-content-between">
                            <div class="title">
                                <div class="icon"><i class="icon-user-1"></i></div>
                                <strong>{{ __('Users') }}</strong>
                            </div>
                            <div class="number dashtext-1">{{ $usersCount }}</div>
                        </div>
                        <div class="progress progress-template">
                            <div role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0"
                                aria-valuemax="100" class="progress-bar progress-bar-template dashbg-1"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="statistic-block block">
                        <div class="progress-details d-flex align-items-end justify-content-between">
                            <div class="title">
                                <div class="icon"><i class="icon-contract"></i></div>
                                <strong>{{ __('Animes') }}</strong>
                            </div>
                            <div class="number dashtext-2">{{ $animesCount }}</div>
                        </div>
                        <div class="progress progress-template">
                            <div role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0"
                                aria-valuemax="100" class="progress-bar progress-bar-template dashbg-2"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="statistic-block block">
                        <div class="progress-details d-flex align-items-end justify-content-between">
                            <div class="title">
                                <div class="icon"><i class="icon-paper-and-pencil"></i></div>
                                <strong>{{ __('Genres') }}</strong>
                            </div>
                            <div class="number dashtext-3">{{ $genresCount }}</div>
                        </div>
                        <div class="progress progress-template">
                            <div role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0"
                                aria-valuemax="100" class="progress-bar progress-bar-template dashbg-3"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="statistic-block block">
                        <div class="progress-details d-flex align-items-end justify-content-between">
                            <div class="title">
                                <div class="icon"><i class="icon-writing-whiteboard"></i></div>
                                <strong>{{ __('Episodes') }}</strong>
                            </div>
                            <div class="number dashtext-4">{{ $episodesCount }}</div>
                        </div>
                        <div class="progress progress-template">
                            <div role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0"
                                aria-valuemax="100" class="progress-bar progress-bar-template dashbg-4"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="no-padding-top no-padding-bottom">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="h5">{{ __('Top Animes') }}</h2>
                        </div>
                        <div class="card-body">
                            <table class="table table-responsive table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">{{ __('#') }}</th>
                                        <th>{{ __('Anime') }}</th>
                                        <th class="text-center">{{ __('Views') }}</th>
                                        <th class="text-center">{{ __('AppViews') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($topAnimes as $anime)
                                        <tr>
                                            <th class="text-center">{{ $loop->iteration }}</th>
                                            <td>{{ $anime->name }}</td>
                                            <td class="text-center">{{ formatNumber($anime->views) }}</td>
                                            <td class="text-center">{{ formatNumber($anime->views_app) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
