# REST API Queries

*Make any WP_Query a REST API query.*

## The use case
See [this article](http://theaveragedev.com/wp-rest-api-query-00/) for the original idea.  
TL;DR: have WordPress REST API formatted post results on the PHP side of WordPress too for template based, gracefully degrading [WordPress REST API](!g) based applications.

## Code pitch 
Let's write the loop content area template file with [Handlebars.js](!g) syntax in the `loop-content.handlebars` file:

```
{{#if posts}}
    <ul>
    {{#each posts}}
        <li>
			{{post.title.rendered}}
        </li>
    {{/each}}
    </ul>
{{else}}
    <p>Nothing found!</p>
{{/if}}
```

Let's say WordPress we would like to "RESTify" the query results on archives in the theme `functions.php` file:

```php
<?php
add_action('pre_get_posts', function( WP_Query $query){
	if(!$query->is_main_query() || !$query->is_archive() || is_admin()){
		return;
	}	
	
	$query['restify'] = true;
});
```

Let's render the initial state with PHP:

```php
<?php 
use Handlebars\Handlebars;

$handlebars = new Handlebars(array(
	'loader' => new \Handlebars\Loader\FilesystemLoader(__DIR__.'/templates/'),
	'partials_loader' => new \Handlebars\Loader\FilesystemLoader(
		__DIR__ . '/templates/',
		array(
			'prefix' => '_'
		)
	)
));
?>

<?php get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main" role="main">

            <header class="page-header">
                <?php
                    the_archive_title( '<h1 class="page-title">', '</h1>' );
                    the_archive_description( '<div class="taxonomy-description">', '</div>' );
                ?>

                // This is relevant!
                <?php get_template_part( 'template-parts/archive-search' );

            </header><!-- .page-header -->

            <div id="content-area">
                <?php
                
                global $wp_query;
             	
             	// these will have the same format as the REST API response data!
                $posts = $wp_query->posts;
                $restified_posts = [];
                
                foreach($posts as $post){
                	$restified_posts[] = $post->data;
                }
                
             	echo $handlebars->render('loop-content', $posts);
             	
                ?>
            </div><!-- #content-area -->

        </main><!-- .site-main -->
    </div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
```

Successive renders will be managed by JavaScript using the same Handlebars template and relying on the same data formmat.

## Installation

Clone the repository:

```bash
git clone https://github.com/lucatume/rest-query.git rest-query
cd rest-query
composer update
```

Activate the plugin.

## RESTifying a WP_Query
To make sure back-compatibility with anything relying on the query to return an array of `WP_Post` objects any query where the `restify` query variable has been set to `true` will return an array of `WP_Post` as usual.  
Each post will have but the `data` property set to what its REST API plugin response counterpart would be.  

```php
$query = new WP_Query(['post_type' => 'post', 'restify' => true]);
$posts = $query->posts;
$data = $posts[0]->data;
$title = $data['title']['rendered'];
```

## restquery_Query class
The `restquery_Query` is a wrapping of the default `WP_Query` class that will return REST data format posts by default; it does not differ from the parent when it comes to using it:

```php
$query = new restquery_Query(['post_type' => 'post']);
if($query->have_posts()){
	while($query->have_posts()){
		$query->the_post();
		
		global $post;
		
		echo $post['title']['rendered'];
	}
}
```

## Functions 
The `restquery_get_posts()` function allows for `data` only based responses to be fetched.  
It's for all intents and purposes the PHP alter ego of a REST API response.

```php
$posts = restquery_get_posts(['post_type' => 'post']);
$title = $posts[0]['title']['rendered'];
```
