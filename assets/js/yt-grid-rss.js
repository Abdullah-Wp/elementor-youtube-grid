jQuery( window ).on( 'elementor/frontend/init', function() {
    // Hooks cleanly into Elementor's standard component registration lifecycle.
    // Handles initial rendering as well as live controls updates inside the visual editor.
    elementorFrontend.hooks.addAction( 'frontend/element_ready/youtube_grid_rss.default', function( $scope ) {
        const placeholders = $scope.find( '.yt-lazy-placeholder' );
        
        // --- LAZY LOAD HANDLER ---
        if ( placeholders.length ) {
            const loadPlaceholder = function( placeholder ) {
                const lazyImage = placeholder.querySelector( 'img' );
                if ( lazyImage && lazyImage.dataset.src ) {
                    lazyImage.src = lazyImage.dataset.src;
                    
                    lazyImage.onload = function() {
                        placeholder.classList.add( 'yt-loaded' );
                        
                        const loader = placeholder.querySelector( '.yt-lazy-loader-wrapper' );
                        if ( loader ) {
                            loader.remove();
                        }
                    };

                    lazyImage.onerror = function() {
                        const loader = placeholder.querySelector( '.yt-lazy-loader-wrapper' );
                        if ( loader ) {
                            loader.remove();
                        }
                        placeholder.style.backgroundColor = '#f3f3f3';
                        console.error( 'YouTube thumbnail was unreachable: ' + lazyImage.dataset.src );
                    };
                }
            };

            // Leverage high-performance asynchronous IntersectionObservers where supported
            if ( 'IntersectionObserver' in window ) {
                const observer = new IntersectionObserver( function( entries, observerInstance ) {
                    entries.forEach( function( entry ) {
                        if ( entry.isIntersecting ) {
                            loadPlaceholder( entry.target );
                            observerInstance.unobserve( entry.target );
                        }
                    });
                }, { rootMargin: '0px 0px 150px 0px' });

                placeholders.each( function() {
                    observer.observe( this );
                });
            } else {
                // Smooth legacy fallback strategy
                placeholders.each( function() {
                    loadPlaceholder( this );
                });
            }
        }

        // --- DUAL-COMPATIBILITY LIGHTBOX INTERCEPTOR ---
        $scope.on( 'click', 'a.elementor-open-lightbox', function( e ) {
            e.preventDefault();
            const videoUrl = jQuery( this ).attr( 'href' );

            if ( window.elementorFrontend && elementorFrontend.utils && elementorFrontend.utils.lightbox ) {
                const lightboxVar = elementorFrontend.utils.lightbox;

                // Defensive helper function to trigger the modal trigger safely
                const triggerLightboxModal = function( lightboxObj ) {
                    if ( lightboxObj && typeof lightboxObj.showModal === 'function' ) {
                        lightboxObj.showModal({
                            type: 'video',
                            url: videoUrl
                        });
                        return true;
                    }
                    return false;
                };

                // Check if modern asynchronous promise patterns apply
                if ( lightboxVar instanceof Promise || ( typeof lightboxVar === 'object' && typeof lightboxVar.then === 'function' ) ) {
                    lightboxVar.then( function( resolvedLightbox ) {
                        if ( ! triggerLightboxModal( resolvedLightbox ) ) {
                            window.open( videoUrl, '_blank' );
                        }
                    }).catch( function( err ) {
                        console.error( 'Elementor Lightbox Promise failed:', err );
                        window.open( videoUrl, '_blank' );
                    });
                } else {
                    // Sync fallback for older versions of the elementor core
                    if ( ! triggerLightboxModal( lightboxVar ) ) {
                        window.open( videoUrl, '_blank' );
                    }
                }
            } else {
                // Safe fallback to prevent broken customer journeys
                window.open( videoUrl, '_blank' );
            }
        });
    });
});