<nav id="site-navigation" class="c-main-navigation" role="navigation" itemscope itemtype="https://schema.org/SiteNavigationElement">
   
   <?php 
   gdt_nav_menu( 'main-menu', 'c-main-menu', array(
      'walker' => new Accessible_Nav_Walker()
   )); // Adjust using Menus in WordPress Admin 
   ?>
   

    <!-- popout search -->
    <button id="search-button" aria-label="Open search" aria-expanded="false" aria-controls="search-popup">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
<path d="M17.5 17.5L14.5834 14.5833M16.6667 9.58333C16.6667 13.4954 13.4954 16.6667 9.58333 16.6667C5.67132 16.6667 2.5 13.4954 2.5 9.58333C2.5 5.67132 5.67132 2.5 9.58333 2.5C13.4954 2.5 16.6667 5.67132 16.6667 9.58333Z" stroke="currentColor" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
    </button> 
    <div id="search-popup" role="dialog" aria-hidden="true" inert="true">
    <button type="button" id="close-search-popup" class="c-search-close-button" aria-label="Close search popup" onclick="closeSearchPopup()">
    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="m13.41 12l4.3-4.29a1 1 0 1 0-1.42-1.42L12 10.59l-4.29-4.3a1 1 0 0 0-1.42 1.42l4.3 4.29l-4.3 4.29a1 1 0 0 0 0 1.42a1 1 0 0 0 1.42 0l4.29-4.3l4.29 4.3a1 1 0 0 0 1.42 0a1 1 0 0 0 0-1.42Z"/></svg>
    </button>
    <form role="search" method="get" id="search-form" class="c-search-form" action="<?php echo home_url( '/' ); ?>">
        <div>
        <label for="s" class="u-visually-hidden">Search for:</label>
        <input type="search" id="s" name="s" value="" class="search-input" placeholder="Search..." />
        <button type="submit" id="search-submit" class="search-submit">Search</button>
        </div>
    </form>
    </div>
    <!-- popout search -->

</nav>
