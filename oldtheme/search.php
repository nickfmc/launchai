<?php get_header(); ?>

<div class="o-layout-row">
  <main id="main-content" class="o-wrapper-wide" role="main" itemscope itemprop="mainContentOfPage" itemtype="https://schema.org/WebPageElement">


  <section class="editor-content">
  <div class=" alignwide  mt-10">
    
    <div class="c-search-content">
    <h1 class="h3-style" role="heading" aria-level="1"><span>Search Results for:</span> <?php echo esc_attr(get_search_query()); ?></h1>
  <div class="c-search-inner-content">
    <div>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
     
               <article <?php post_class(); ?> role="article">
          <header class="c-article-header">
             <!-- Post Type Pills - Add your CPTs here -->
          <div class="c-pill-wrap">
            <?php if (get_post_type() == 'post') : ?>
                <span class="c-pill-tag post-tag">Post</span>
              <?php elseif (get_post_type() == 'page') : ?>
                <span class="c-pill-tag page-tag">Page</span>
              <?php endif; ?>
          </div>
            <!-- Post Type Pills - Add your CPTs here -->
            <h2 class="h5-style">
              <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
            </h2>
            
          </header>
          <!-- /c-article-header -->
          <section class="c-excerpt-content">
            <?php the_excerpt(); ?>
          </section>
          <a class="c-btn-textonly" href="<?php the_permalink() ?>">Read More <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 16 16"><path fill="none" stroke="currentColor" d="M3 8h10m-3.25 3.5l3.5-3.5l-3.5-3.5"/></svg></a>
          <!-- /c-excerpt-content -->

         
        </article>
        <!-- /article -->
            <?php endwhile; ?>
        <?php get_template_part( 'template-part/post/post-nav' ); ?>
        
            <?php else : ?>
        <article class="PostNotFound">
          <header class="ArticleHeader">
            <h4><?php _e("Sorry, No Results.", "flexdev"); ?></h4>
          </header>
          <section class="EntryContent">
            <p><?php _e("Please try another search.", "flexdev"); ?></p>
          </section>
        </article>
  
    <?php endif; ?>
            </div>
    </div>
    </div>
</div>




  </div>



    
    
   
    </section>
  </main>
</div>
<!-- /layout-row-->

<?php get_footer(); ?>
