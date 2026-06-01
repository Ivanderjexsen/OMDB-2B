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
                                      <img src="{{ $favorite['Poster'] }}" alt="{{ $favorite['Title'] }}" class="img-fluid movie-poster" style="max-width: 80px;" data-title="{{ $favorite['Title'] ?? '' }}" data-year="{{ $favorite['Year'] ?? '' }}" data-type="{{ $favorite['Type'] ?? '' }}" data-imdbid="{{ $favorite['imdbID'] ?? '' }}" data-poster="{{ $favorite['Poster'] ?? '' }}" />
                                    @else
                                      <span class="text-muted">{{ __('No image') }}</span>
                                    @endif
                                  </td>
                                  <td>{{ $favorite['Title'] ?? '-' }}</td>
                                  <td>{{ $favorite['Year'] ?? '-' }}</td>
                                  <td>{{ ucfirst($favorite['Type'] ?? '-') }}</td>
                                  <td>
                                    @if(! empty($favorite['imdbID']))
                                      <a href="{{ url('controlpanel/movie') }}/{{ $favorite['imdbID'] }}" class="btn btn-sm btn-info mr-2">
                                        <i class="fas fa-eye"></i> {{ __('Detail') }}
                                      </a>
                                      <form method="POST" action="{{ route('favorite.remove') }}" class="d-inline remove-favorite-form" data-title="{{ $favorite['Title'] ?? '' }}" data-imdbid="{{ $favorite['imdbID'] }}">
                                        @csrf
                                        <input type="hidden" name="imdbID" value="{{ $favorite['imdbID'] }}">
                                        <button type="button" class="btn btn-sm btn-danger remove-favorite-button" data-title="{{ $favorite['Title'] ?? '' }}">{{ __('Remove') }}</button>
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

        <!-- Remove Favorite Confirmation Modal -->
        <div class="modal fade nonblocking-modal" id="confirmRemoveFavoriteModal" tabindex="-1" role="dialog" aria-labelledby="confirmRemoveFavoriteModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="confirmRemoveFavoriteModalLabel">{{ __('Remove from Favorites') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>{{ __('Are you sure you want to remove this movie from your favorites?') }}</p>
                <p><strong id="remove-favorite-movie-title"></strong></p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                <button type="button" class="btn btn-danger" id="confirm-remove-favorite-submit">{{ __('Yes, remove') }}</button>
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
        var removeForm = null;

        $('.remove-favorite-button').off('click').on('click', function () {
          removeForm = $(this).closest('form');
          var title = $(this).data('title') || '{{ __('this movie') }}';
          $('#remove-favorite-movie-title').text(title);
          $('#confirmRemoveFavoriteModal').modal({backdrop:false, keyboard:true, focus:false});
        });

        $('#confirm-remove-favorite-submit').off('click').on('click', function () {
          if (removeForm) {
            removeForm.submit();
          }
        });
      });
    </script>

  

