<?php
/*
Template Name: Blog Main Page
*/
?>

<?php get_header(); ?>

<div class="o-layout-row">
  <main id="main-content" class="c-blog-main" role="main" itemscope itemprop="mainContentOfPage" itemtype="https://schema.org/WebPageElement">
    
    <!-- Blog Hero Section -->


    <!-- Blog Posts Grid -->
    <section class="c-blog-posts">
      <div class="o-wrapper-wide">
        <?php
          $temp = $wp_query;
          $wp_query = null;
          $wp_query = new WP_Query(
            array(
              'posts_per_page' => 9,
              'paged' => $paged
            )
          );
        ?>
        
        <?php if ($wp_query->have_posts()) : ?>
          <div class="c-blog-grid">
            <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
              <article <?php post_class('c-blog-card'); ?> role="article" itemscope itemtype="https://schema.org/BlogPosting">
                
                <?php if (has_post_thumbnail()) : ?>
                  <div class="c-blog-card-image">
                    <a href="<?php the_permalink(); ?>" aria-label="Read more about <?php the_title_attribute(); ?>">
                      <?php the_post_thumbnail('large', array('class' => 'c-blog-card-img')); ?>
                    </a>
                  </div>
                <?php endif; ?>
                
                <div class="c-blog-card-content">
                  <div class="c-blog-card-meta">
                    <time datetime="<?php the_time('Y-m-d'); ?>" itemprop="datePublished" class="c-blog-card-date">
                      <?php the_time('M j, Y'); ?>
                    </time>
                    <div class="c-blog-card-categories">
                      <?php 
                        $categories = get_the_category();
                        if (!empty($categories)) {
                          echo '<span class="c-blog-card-category">' . esc_html($categories[0]->name) . '</span>';
                        }
                      ?>
                    </div>
                  </div>
                  
                  <h2 class="c-blog-card-title" itemprop="headline">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                  </h2>
                  
                  <div class="c-blog-card-excerpt" itemprop="description">
                    <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                  </div>
                  
                  <div class="c-blog-card-footer">
                   
                    <a href="<?php the_permalink(); ?>" class="c-blog-card-read-more">
                      Read More
                      <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3.33334 8H12.6667M9.33334 4.66667L12.6667 8L9.33334 11.3333" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </a>
                  </div>
                </div>
              </article>
            <?php endwhile; ?>
          </div>
        <?php endif; ?>        <!-- Blog Pagination -->
        <?php if ( $wp_query->max_num_pages > 1 ) : ?>
          <nav class="c-blog-pagination" aria-label="Blog pagination">
            <div class="c-blog-pagination-wrapper">
              <?php
                $pagination_args = array(
                  'total' => $wp_query->max_num_pages,
                  'current' => max(1, $paged),
                  'format' => '?paged=%#%',
                  'show_all' => false,
                  'prev_next' => true,
                  'prev_text' => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.5 15L7.5 10L12.5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> Previous',
                  'next_text' => 'Next <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.5 15L12.5 10L7.5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
                  'mid_size' => 2,
                  'end_size' => 1,
                  'type' => 'list'
                );
                echo paginate_links($pagination_args);
              ?>
            </div>
          </nav>
        <?php endif; ?>

        <?php $wp_query = null; $wp_query = $temp; ?>
        <?php wp_reset_postdata(); ?>
      </div>
    </section>

  </main>
</div>
<!-- /layout-row -->

<?php get_footer(); ?>
