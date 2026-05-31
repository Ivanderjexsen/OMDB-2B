@include('controlpanel.components.header')




      <!-- Main Content -->
      <div class="main-content" style="min-height: 896px">
        <section class="section">
          <div class="section-header">
            <h1>{{ __('My Favorites') }}</h1>
          </div>
          <div class="section-body">
            <div class="row mt-4">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>{{ __('Favorite Movies') }}</h4>
                  </div>
                  <div class="card-body">
                    @if (session('success'))
                      <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div id="favorites-content">
                      @if(! empty($favorites) && count($favorites))
                        <div class="table-responsive">
                          <table class="table table-striped">
                            <thead>
                              <tr>
                                <th>{{ __('Poster') }}</th>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Year') }}</th>
                                <th>{{ __('Type') }}</th>
                                <th>{{ __('Action') }}</th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($favorites as $favorite)
                                <tr>
                                  <td>
                                    @if(! empty($favorite['Poster']) && $favorite['Poster'] !== 'N/A')
                                      <img src="{{ $favorite['Poster'] }}" alt="{{ $favorite['Title'] }}" class="img-fluid movie-poster" style="max-width: 80px; cursor: pointer;" data-title="{{ $favorite['Title'] ?? '' }}" data-year="{{ $favorite['Year'] ?? '' }}" data-type="{{ $favorite['Type'] ?? '' }}" data-imdbid="{{ $favorite['imdbID'] ?? '' }}" data-poster="{{ $favorite['Poster'] ?? '' }}" />
                                    @else
                                      <span class="text-muted">{{ __('No image') }}</span>
                                    @endif
                                  </td>
                                  <td>{{ $favorite['Title'] ?? '-' }}</td>
                                  <td>{{ $favorite['Year'] ?? '-' }}</td>
                                  <td>{{ ucfirst($favorite['Type'] ?? '-') }}</td>
                                  <td>
                                    @if(! empty($favorite['imdbID']))
                                      <form method="POST" action="{{ route('favorite.remove') }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="imdbID" value="{{ $favorite['imdbID'] }}">
                                        <button type="submit" class="btn btn-sm btn-danger">{{ __('Remove') }}</button>
                                      </form>
                                    @else
                                      -
                                    @endif
                                  </td>
                                </tr>
                              @endforeach
                            </tbody>
                          </table>
                        </div>
                      @else
                        <div class="text-center py-5">
                          <i class="fas fa-heart-broken fa-3x text-muted mb-3 d-block"></i>
                          <h5 class="text-muted">{{ __('No favorites yet') }}</h5>
                          <p class="text-muted">{{ __('Start adding movies to your favorites list!') }}</p>
                          <a href="{{ url('/controlpanel/dashboard') }}" class="btn btn-primary mt-2" >
                            <i class="fas fa-search"></i> {{ __('find your favorite movie') }}
                          </a>
                        </div>
                      @endif
                    </div>
                  </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Movie detail modal -->
        <div class="modal fade nonblocking-modal" id="favoriteMovieDetailModal" tabindex="-1" role="dialog" aria-labelledby="favoriteMovieDetailModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="favoriteMovieDetailModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body text-center">
                <img id="favorite-detail-poster" src="" alt="" class="img-fluid mb-3" style="max-height: 350px;" />
                <p><strong>{{ __('Year') }}:</strong> <span id="favorite-detail-year"></span></p>
                <p><strong>{{ __('Type') }}:</strong> <span id="favorite-detail-type"></span></p>
                <p><strong>{{ __('IMDb ID') }}:</strong> <span id="favorite-detail-imdb"></span></p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
              </div>
            </div>
          </div>
        </div>

        @include('controlpanel.components.footer')

        <style>
          .nonblocking-modal .modal-dialog { margin-top: 110px; }
          .nonblocking-modal .modal-content { max-height: 60vh; overflow-y: auto; }
        </style>

        <script>
          $(document).ready(function () {
            $('.movie-poster').off('click').on('click', function () {
              $('#favoriteMovieDetailModalLabel').text($(this).data('title') || '{{ __('Movie Detail') }}');
              $('#favorite-detail-poster').attr('src', $(this).data('poster') || '');
              $('#favorite-detail-poster').attr('alt', $(this).data('title') || '');
              $('#favorite-detail-year').text($(this).data('year') || '-');
              $('#favorite-detail-type').text($(this).data('type') || '-');
              $('#favorite-detail-imdb').text($(this).data('imdbid') || '-');
              $('#favoriteMovieDetailModal').modal({backdrop:false, keyboard:true, focus:false});
            });
          });
        </script>

  

