<?php

/**
 * fancy-divider Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'glossary-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'c-glossary';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}
if( $is_preview ) {
    $className .= ' is-admin';
}

?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
<?php // Get the repeater field data
if (have_rows('glossary_repeater_field')) :
    $glossary = [];

    // Loop through glossary terms
    while (have_rows('glossary_repeater_field')) : the_row();
        $term = get_sub_field('term');
        $description = get_sub_field('description');
        $first_letter = strtoupper(substr($term, 0, 1));

        // Group terms by the first letter
        $glossary[$first_letter][] = [
            'term' => $term,
            'description' => $description,
        ];
    endwhile;

    // Sort glossary alphabetically by letters
    ksort($glossary);
?>

<div class="glossary-navigation">
    <?php 
    // Create array of all alphabet letters
    $alphabet = range('A', 'Z');
    
    // Loop through entire alphabet
    foreach ($alphabet as $letter) :
        // Check if this letter exists in our glossary
        $hasTerms = isset($glossary[$letter]);
        
        if ($hasTerms) {
            // If letter has terms, make it clickable
            echo '<a href="#' . $letter . '" class="has-terms">' . $letter . '</a>';
        } else {
            // If letter has no terms, add disabled class
            echo '<span class="no-terms">' . $letter . '</span>';
        }
    endforeach; 
    ?>
</div>


<div class="glossary-content">
    <?php foreach ($glossary as $letter => $items) : ?>
        <div id="<?php echo $letter; ?>" class="glossary-section">
            <h2><?php echo $letter; ?></h2>
            <ul>
                <?php foreach ($items as $item) : ?>
                    <li>
                        <strong><?php echo $item['term']; ?></strong>: <?php echo $item['description']; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endforeach; ?>
</div>

<?php else : ?>
    <p>No glossary terms found.</p>
<?php endif; ?>
</div>
