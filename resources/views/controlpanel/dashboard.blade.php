@include("controlpanel.components.header")

      <!-- Main Content -->
      <div class="main-content" style="min-height: 896px">
        <section class="section">
          <div class="section-header">
            <h1>{{__('Movies') }}</h1>
          </div>
          <div class="section-body">
            <div class="row mt-4">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>{{__('All Movies') }}</h4>
                  </div>
                  <div class="card-body">
                    <div class="d-flex justify-content-end mb-3">
                      <form method="GET" action="{{ route('dashboard') }}" class="w-100" style="max-width: 300px;">
                        <div class="search-element">
                          <div class="input-group">
                            <input type="text" name="q" id="search-input" class="form-control" value="{{ old('q', $query ?? '') }}" placeholder="{{__('search for movies') }}">
                            <div class="input-group-append">
                              <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                              </button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>

                    @if (session('success'))
                      <div class="alert alert-success alert-dismissible show fade">
                        <div class="alert-body">
                          <button class="close" data-dismiss="button"><span>&times;</span></button>
                          {{ session('success') }}
                        </div>
                      </div>
                    @endif
                    
                    @if (! empty($error))
                      <div class="alert alert-warning alert-dismissible show fade">
                        <div class="alert-body">
                          <button class="close" data-dismiss="button"><span>&times;</span></button>
                          {{ $error }}
                        </div>
                      </div>
                    @endif
                  </div>
                <div class="table-responsive">
                    <table class="table table-striped" id="movie-table">
                      <thead>
                        <tr>
                          <th>{{__('Poster') }}</th>
                          <th>{{__('Title') }}</th>
                          <th>{{__('Year') }}</th>
                          <th>{{__('Type') }}</th>
                          <th>{{__('Action') }}</th>
                        </tr>
                      </thead>
                      <tbody id="Movie-container">
                        @if(! empty($movies) && $movies->count())
                          @foreach($movies as $movie)
                            <tr>
                              <td>
                                @if(! empty($movie['Poster']) && $movie['Poster'] !== 'N/A')
                                  <img src="{{ $movie['Poster'] }}" alt="{{ $movie['Title'] }}" class="img-fluid movie-poster" style="max-width: 80px; cursor: pointer;" data-title="{{ $movie['Title'] ?? '' }}" data-year="{{ $movie['Year'] ?? '' }}" data-type="{{ $movie['Type'] ?? '' }}" data-imdbid="{{ $movie['imdbID'] }}" data-poster="{{ $movie['Poster'] }}" />
                                @else
                                  <span class="text-muted">{{ __('No image') }}</span>
                                @endif
                              </td>
                              <td>{{ $movie['Title'] ?? '-' }}</td>
                              <td>{{ $movie['Year'] ?? '-' }}</td>
                              <td>{{ ucfirst($movie['Type'] ?? '-') }}</td>
                              <td>
                                @if(! empty($movie['imdbID']))
                                  <form method="POST" action="{{ route('dashboard.favorite') }}" class="d-inline favorite-form" data-title="{{ $movie['Title'] ?? '' }}">
                                    @csrf
                                    <input type="hidden" name="Title" value="{{ $movie['Title'] ?? '' }}">
                                    <input type="hidden" name="Year" value="{{ $movie['Year'] ?? '' }}">
                                    <input type="hidden" name="Type" value="{{ $movie['Type'] ?? '' }}">
                                    <input type="hidden" name="Poster" value="{{ $movie['Poster'] ?? '' }}">
                                    <input type="hidden" name="imdbID" value="{{ $movie['imdbID'] }}">
                                    <button class="btn btn-sm btn-danger favorite-button" type="button" data-title="{{ $movie['Title'] ?? '' }}">
                                      <i class="fas fa-heart"></i> {{ __('Love') }}
                                    </button>
                                  </form>
                                @else
                                  -
                                @endif
                              </td>
                            </tr>
                          @endforeach
                        @else
                          <tr id="empty-row">
                            <td colspan="5" class="text-center py-5">
                              <i class="fas fa-search fa-3x text-muted mb-3 d-block"></i>
                              <span class="text-muted">
                                @if(! empty($query))
                                  {{ __('No movies found for :query', ['query' => $query]) }}
                                @else
                                  {{__('enter keywords to search for movies') }}
                                @endif
                              </span>
                            </td>
                          </tr>
                        @endif
                      </tbody>
                    </table>
                  </div>
              </div>
            </div>
          </div>
        </section>
      </div>

      <!-- Favorite confirm modal -->
      <div class="modal fade nonblocking-modal" id="confirmFavoriteModal" tabindex="-1" role="dialog" aria-labelledby="confirmFavoriteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="confirmFavoriteModalLabel">{{ __('Add to Favorites') }}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>{{ __('Are you sure you want to add this movie to your favorites?') }}</p>
              <p><strong id="favorite-movie-title"></strong></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
              <button type="button" class="btn btn-danger" id="confirm-favorite-submit">{{ __('Yes, add favorite') }}</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Movie detail modal -->
      <div class="modal fade nonblocking-modal" id="movieDetailModal" tabindex="-1" role="dialog" aria-labelledby="movieDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="movieDetailModalLabel"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body text-center">
              <img id="detail-poster" src="" alt="" class="img-fluid mb-3" style="max-height: 350px;" />
              <p><strong>{{ __('Year') }}:</strong> <span id="detail-year"></span></p>
              <p><strong>{{ __('Type') }}:</strong> <span id="detail-type"></span></p>
              <p><strong>{{ __('IMDb ID') }}:</strong> <span id="detail-imdb"></span></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
            </div>
          </div>
        </div>
      </div>

@include("controlpanel.components.footer")

<style>
  /* Non-blocking modal: push down so it won't cover top search bar */
  .nonblocking-modal .modal-dialog { margin-top: 110px; }
  .nonblocking-modal .modal-content { max-height: 60vh; overflow-y: auto; }
</style>

<script>
  $(document).ready(function () {
    var favoriteForm = null;

    $('.favorite-button').off('click').on('click', function () {
      favoriteForm = $(this).closest('form');
      var title = $(this).data('title') || '{{ __('this movie') }}';
      $('#favorite-movie-title').text(title);
      $('#confirmFavoriteModal').modal({backdrop:false, keyboard:true, focus:false});
    });

    $('#confirm-favorite-submit').off('click').on('click', function () {
      if (favoriteForm) {
        favoriteForm.submit();
      }
    });

    $('.movie-poster').off('click').on('click', function () {
      $('#movieDetailModalLabel').text($(this).data('title') || '{{ __('Movie Detail') }}');
      $('#detail-poster').attr('src', $(this).data('poster') || '');
      $('#detail-poster').attr('alt', $(this).data('title') || '');
      $('#detail-year').text($(this).data('year') || '-');
      $('#detail-type').text($(this).data('type') || '-');
      $('#detail-imdb').text($(this).data('imdbid') || '-');
      $('#movieDetailModal').modal({backdrop:false, keyboard:true, focus:false});
    });
  });
</script>
