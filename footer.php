<footer class="o-section c-page-footer" id="c-page-footer" role="contentinfo" itemscope itemtype="https://schema.org/WPFooter">

    <div class="c-page-footer-upper">
      <div class="o-wrapper-wide">
      <div class="grid-x">
          <div class="cell  medium-3">
            <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
              <?php dynamic_sidebar( 'footer-1' ); ?>
            <?php endif; ?>
          </div>
          <div class="cell  medium-3">
          <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
            <?php dynamic_sidebar( 'footer-2' ); ?>
          <?php endif; ?>
          </div>
          <div class="cell  medium-3">
          <?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
            <?php dynamic_sidebar( 'footer-3' ); ?>
          <?php endif; ?>
          </div>
          <div class="cell  medium-3">
          <?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
            <?php dynamic_sidebar( 'footer-4' ); ?>
          <?php endif; ?>
          </div>
        </div>
        <!-- /.c-footer-widgets -->
        
        <!-- /.c-logo-copy-wrap -->
      </div>
      <!-- /.o-wrapper-wide -->
    </div>
    <div class="c-page-footer-lower">
      <div class="o-wrapper-wide">
        <div class="">
            <div class="c-copywrite">
              &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>.
            </div>
            <div class="c-footer-social">
              <a target="_blank" href="https://x.com" aria-label="Visit our X profile">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M15.9455 23L10.396 15.0901L3.44886 23H0.509766L9.09209 13.2311L0.509766 1H8.05571L13.286 8.45502L19.8393 1H22.7784L14.5943 10.3165L23.4914 23H15.9455ZM19.2185 20.77H17.2398L4.71811 3.23H6.6971L11.7121 10.2532L12.5793 11.4719L19.2185 20.77Z" fill="#A4A7AE"/>
                </svg>
              </a>
              <a target="_blank" href="https://linkedin.com" aria-label="Visit our LinkedIn profile">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <path d="M22.2234 0H1.77187C0.792187 0 0 0.773438 0 1.72969V22.2656C0 23.2219 0.792187 24 1.77187 24H22.2234C23.2031 24 24 23.2219 24 22.2703V1.72969C24 0.773438 23.2031 0 22.2234 0ZM7.12031 20.4516H3.55781V8.99531H7.12031V20.4516ZM5.33906 7.43438C4.19531 7.43438 3.27188 6.51094 3.27188 5.37187C3.27188 4.23281 4.19531 3.30937 5.33906 3.30937C6.47813 3.30937 7.40156 4.23281 7.40156 5.37187C7.40156 6.50625 6.47813 7.43438 5.33906 7.43438ZM20.4516 20.4516H16.8937V14.8828C16.8937 13.5562 16.8703 11.8453 15.0422 11.8453C13.1906 11.8453 12.9094 13.2937 12.9094 14.7891V20.4516H9.35625V8.99531H12.7687V10.5609H12.8156C13.2891 9.66094 14.4516 8.70938 16.1813 8.70938C19.7859 8.70938 20.4516 11.0813 20.4516 14.1656V20.4516Z" fill="#A4A7AE"/>
                </svg>
              </a>
              <a target="_blank" href="https://facebook.com" aria-label="Visit our Facebook profile">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <g clip-path="url(#clip0_1507_262311)">
                    <path d="M24 12C24 5.37258 18.6274 0 12 0C5.37258 0 0 5.37258 0 12C0 17.9895 4.3882 22.954 10.125 23.8542V15.4688H7.07812V12H10.125V9.35625C10.125 6.34875 11.9166 4.6875 14.6576 4.6875C15.9701 4.6875 17.3438 4.92188 17.3438 4.92188V7.875H15.8306C14.34 7.875 13.875 8.80008 13.875 9.75V12H17.2031L16.6711 15.4688H13.875V23.8542C19.6118 22.954 24 17.9895 24 12Z" fill="#A4A7AE"/>
                  </g>
                  <defs>
                    <clipPath id="clip0_1507_262311">
                      <rect width="24" height="24" fill="white"/>
                    </clipPath>
                  </defs>
                </svg>
              </a>
            </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- /.c-page-footer -->

  <?php // get_template_part( 'template-part/navigation/nav-modal' ); ?>

  <!-- Accessibility Widget -->
  <button class="a11y-widget" id="a11y-widget" aria-label="Accessibility options" aria-expanded="false" aria-controls="a11y-popup">
    <span class="a11y-widget__icon" aria-hidden="true">
      <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10"></circle>
        <path d="M12 8v4"></path>
        <path d="M12 16h.01"></path>
      </svg>
    </span>
  </button>

  <div class="a11y-popup" id="a11y-popup" aria-hidden="true" inert>
    <div class="a11y-popup__header">
      <h3>Accessibility Options</h3>
      <button id="a11y-close" aria-label="Close accessibility options">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="18" y1="6" x2="6" y2="18"></line>
          <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
      </button>
    </div>
    
    <div class="a11y-popup__options">
      <div class="a11y-popup__option">
        <label for="a11y-high-contrast">High Contrast</label>
        <label class="switch">
          <input type="checkbox" id="a11y-high-contrast">
          <span class="slider"></span>
        </label>
      </div>
      
      <div class="a11y-popup__option">
        <label for="a11y-larger-text">Larger Text</label>
        <label class="switch">
          <input type="checkbox" id="a11y-larger-text">
          <span class="slider"></span>
        </label>
      </div>
      
      <div class="a11y-popup__option">
        <label for="a11y-reduced-motion">Reduce Motion</label>
        <label class="switch">
          <input type="checkbox" id="a11y-reduced-motion">
          <span class="slider"></span>
        </label>
      </div>
      
      <div class="a11y-popup__option">
        <label for="a11y-focus-visible">Enhanced Focus</label>
        <label class="switch">
          <input type="checkbox" id="a11y-focus-visible">
          <span class="slider"></span>
        </label>
      </div>
    </div>
  </div>
  <!-- End Accessibility Widget -->

  <!-- all js scripts are loaded in lib/gdt-enqueues.php -->
  <?php wp_footer(); ?>

</body>
</html>
