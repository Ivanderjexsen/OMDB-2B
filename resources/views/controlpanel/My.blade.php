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
                    <div id="favorites-content">
                      <div class="text-center py-5">
                        <i class="fas fa-heart-broken fa-3x text-muted mb-3 d-block"></i>
                        <h5 class="text-muted">{{ __('No favorites yet') }}</h5>
                        <p class="text-muted">{{ __('Start adding movies to your favorites list!') }}</p>
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary mt-2" >
                          <i class="fas fa-search">{{ __('find your favorite movie') }}</i>
                        </a>
                      </div>
                    </div>`
                  </div>
              </div>
            </div>
          </div>
        </section>

        @include('controlpanel.components.footer')
      
  

  