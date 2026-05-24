<!DOCTYPE html>
<html class="no-js" lang="<?php language_attributes(); ?>">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <!-- we can safely use the favicon uploader in customizer now. plugins such as perf matters will add the missing black favicon.io -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
  <?php // other html head stuff (before WP/theme scripts are loaded) ------- ?>

  <?php wp_head(); // wordpress head functions -- DONOTREMOVE ?>

  <?php // START Google Analytics here ?>
  <?php // END Analytics ?>
</head>
 
<body <?php body_class(pretty_body_class()); ?> itemscope itemtype="https://schema.org/WebPage">
<!-- Skip links should be the first focusable elements -->
<div class="skip-links" role="navigation" aria-label="Skip links navigation">
    <a href="#main-content" class="skip-link" role="link" aria-label="Skip to main content">Skip to main content</a>
    <a href="#site-navigation" class="skip-link" role="link" aria-label="Skip to main navigation">Skip to main navigation</a>
    <a href="#c-page-footer" class="skip-link" role="link" aria-label="Skip to page footer">Skip to page footer</a>
</div>
<!-- END Skip links should be the first focusable elements -->
 
  <header id="c-page-header" class="o-section c-page-header" role="banner" itemscope itemtype="https://schema.org/WPHeader">
    <div class="o-wrapper-wide  u-relative">
      <?php get_template_part( 'template-part/header/logo' ); ?>
      <?php get_template_part( 'template-part/navigation/nav-main' ); ?>
      <?php get_template_part( 'template-part/navigation/nav-tertiary' ); ?>
      
      <!-- <div class="c-modal-nav-button-wrap">
        <a class="toggle hc-nav-trigger mobile-nav" href="#" role="button" aria-label="Open Menu" aria-controls="hc-nav-1" aria-expanded="false">
          <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" preserveAspectRatio="xMidYMid meet" viewBox="0 0 512 512"><path fill="currentColor" d="M32 96v64h448V96H32zm0 128v64h448v-64H32zm0 128v64h448v-64H32z"/></svg>
        </a>
      </div> -->

      <div class="c-cl-mobile-nav">
        <button href="#" id="open-modal-nav" class="c-modal-nav-button"  aria-expanded="false" aria-haspopup="menu" aria-label="Open menu">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
          <path d="M3 12H21M3 6H21M3 18H21" stroke="#414651" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
          </button>
        
        <div class="x-body-wrapper"></div>
          <div id="modal-nav-wrap" class="c-modal-nav-wrap" tabindex="-1">
            <button id="close-modal-nav" class="c-close-modal-nav" aria-label="Close menu">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path d="M18 6L6 18M6 6L18 18" stroke="#414651" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            </button>
            <nav class="c-modal-nav" role="navigation" itemscope itemtype="https://schema.org/SiteNavigationElement">
            <div class="c-modal-nav-header">
              <div class="c-modal-nav-logo">
                <a href="/" rel="nofollow">
                  <img src="<?php bloginfo('template_url') ?>/img/wplogo.png" alt="<?php bloginfo('name'); ?>" />
                </a>
              </div> <!-- /c-main-logo -->
            </div>
            
              <?php  gdt_nav_menu( 'mobile-menu', 'c-mobile-menu' ); // Adjust using Menus in WordPress Admin ?>
              <div class="c-cl-mobile-nav-footer">
                <p>
                  <span aria-label="Address">Address:</span> 1234 Main Street, Anytown, USA 12345<br />
                  <span aria-label="Phone">Phone:</span> 123-456-7890<br />
                  <span aria-label="Email">Email:</span> <a href="mailto:">info@companyname.com</a>
                </p>
                
                <div class="c-cl-mobile-nav-footer-social">
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
            </nav>
          </div> <!-- /modal-nav-wrap -->
      </div>
    </div>
    <!-- /o-wrapper-wide-->
  </header> 
  <!-- /c-page-header -->
