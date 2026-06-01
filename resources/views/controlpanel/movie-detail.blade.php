@include("controlpanel.components.header")

<!-- Main Content -->
<div class="main-content" style="min-height: 896px">
    <section class="section">
        <div class="section-header">
            <h1>{{ __('Movie Details') }}</h1>
        </div>
        <div class="section-body">
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary mb-3">
                                <i class="fas fa-arrow-left"></i> {{ __('Back to Movies') }}
                            </a>

                            @if (!empty($error))
                                <div class="alert alert-warning alert-dismissible show fade">
                                    <div class="alert-body">
                                        <button class="close" data-dismiss="button"><span>&times;</span></button>
                                        {{ $error }}
                                    </div>
                                </div>
                            @elseif (!empty($movie))
                                <div class="row">
                                    <div class="col-md-4 text-center">
                                        @if (!empty($movie['Poster']) && $movie['Poster'] !== 'N/A')
                                            <img src="{{ $movie['Poster'] }}" alt="{{ $movie['Title'] ?? '' }}" class="img-fluid mb-3" style="max-width: 100%; height: auto;" />
                                        @else
                                            <div class="alert alert-info">
                                                {{ __('No poster available') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-8">
                                        <h2>{{ $movie['Title'] ?? '-' }}</h2>
                                        
                                        <div class="detail-info mt-4">
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <strong>{{ __('Year') }}:</strong>
                                                </div>
                                                <div class="col-md-8">
                                                    {{ $movie['Year'] ?? '-' }}
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <strong>{{ __('Type') }}:</strong>
                                                </div>
                                                <div class="col-md-8">
                                                    {{ ucfirst($movie['Type'] ?? '-') }}
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <strong>{{ __('IMDb ID') }}:</strong>
                                                </div>
                                                <div class="col-md-8">
                                                    {{ $movie['imdbID'] ?? '-' }}
                                                </div>
                                            </div>

                                            @if (!empty($movie['Released']))
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <strong>{{ __('Released') }}:</strong>
                                                    </div>
                                                    <div class="col-md-8">
                                                        {{ $movie['Released'] }}
                                                    </div>
                                                </div>
                                            @endif

                                            @if (!empty($movie['Runtime']))
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <strong>{{ __('Runtime') }}:</strong>
                                                    </div>
                                                    <div class="col-md-8">
                                                        {{ $movie['Runtime'] }}
                                                    </div>
                                                </div>
                                            @endif

                                            @if (!empty($movie['Genre']))
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <strong>{{ __('Genre') }}:</strong>
                                                    </div>
                                                    <div class="col-md-8">
                                                        {{ $movie['Genre'] }}
                                                    </div>
                                                </div>
                                            @endif

                                            @if (!empty($movie['Director']))
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <strong>{{ __('Director') }}:</strong>
                                                    </div>
                                                    <div class="col-md-8">
                                                        {{ $movie['Director'] }}
                                                    </div>
                                                </div>
                                            @endif

                                            @if (!empty($movie['Writer']))
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <strong>{{ __('Writer') }}:</strong>
                                                    </div>
                                                    <div class="col-md-8">
                                                        {{ $movie['Writer'] }}
                                                    </div>
                                                </div>
                                            @endif

                                            @if (!empty($movie['Actors']))
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <strong>{{ __('Actors') }}:</strong>
                                                    </div>
                                                    <div class="col-md-8">
                                                        {{ $movie['Actors'] }}
                                                    </div>
                                                </div>
                                            @endif

                                            @if (!empty($movie['Plot']))
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <strong>{{ __('Plot') }}:</strong>
                                                    </div>
                                                    <div class="col-md-8">
                                                        {{ $movie['Plot'] }}
                                                    </div>
                                                </div>
                                            @endif

                                            @if (!empty($movie['imdbRating']) && $movie['imdbRating'] !== 'N/A')
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <strong>{{ __('IMDb Rating') }}:</strong>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <span class="badge badge-primary">{{ $movie['imdbRating'] }}/10</span>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="mt-5">
                                            @if(!empty($movie['imdbID']))
                                                <form method="POST" action="{{ route('dashboard.favorite') }}" class="d-inline favorite-form" data-title="{{ $movie['Title'] ?? '' }}">
                                                    @csrf
                                                    <input type="hidden" name="Title" value="{{ $movie['Title'] ?? '' }}">
                                                    <input type="hidden" name="Year" value="{{ $movie['Year'] ?? '' }}">
                                                    <input type="hidden" name="Type" value="{{ $movie['Type'] ?? '' }}">
                                                    <input type="hidden" name="Poster" value="{{ $movie['Poster'] ?? '' }}">
                                                    <input type="hidden" name="imdbID" value="{{ $movie['imdbID'] }}">
                                                    <button class="btn btn-danger favorite-button" type="button" data-title="{{ $movie['Title'] ?? '' }}">
                                                        <i class="fas fa-heart"></i> {{ __('Add to Favorites') }}
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    {{ __('No movie data available') }}
                                </div>
                            @endif
                        </div>
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

<!-- Result Modal -->
<div class="modal fade nonblocking-modal" id="resultModal" tabindex="-1" role="dialog" aria-labelledby="resultModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="resultModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="resultModalMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">{{ __('OK') }}</button>
            </div>
        </div>
    </div>
</div>

@include("controlpanel.components.footer")

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
        var formData = favoriteForm.serialize();
        
        $.ajax({
          url: favoriteForm.attr('action'),
          method: 'POST',
          data: formData,
          headers: {
            'X-Requested-With': 'XMLHttpRequest'
          },
          success: function(response) {
            $('#confirmFavoriteModal').modal('hide');
            
            $('#resultModalLabel').text('{{ __('Success') }}');
            $('#resultModalMessage').text(response.message || '{{ __('Movie added to favorites.') }}');
            $('#resultModal').modal({backdrop:false, keyboard:true, focus:false});
          },
          error: function(xhr) {
            $('#confirmFavoriteModal').modal('hide');
            
            var errorMessage = '{{ __('An error occurred while adding to favorites.') }}';
            if (xhr.responseJSON && xhr.responseJSON.message) {
              errorMessage = xhr.responseJSON.message;
            }
            
            $('#resultModalLabel').text('{{ __('Error') }}');
            $('#resultModalMessage').text(errorMessage);
            $('#resultModal').modal({backdrop:false, keyboard:true, focus:false});
          }
        });
      }
    });
  });
</script>
