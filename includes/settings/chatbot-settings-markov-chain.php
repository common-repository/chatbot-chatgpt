<?php
/**
 * Kognetiks Chatbot for WordPress - Markov Chain - Settings - Ver 2.1.6.1
 *
 * This file contains the code for the Markov Chain settings page.
 * It manages the settings and other parameters.
 * 
 *
 * @package chatbot-chatgpt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die();
}

// Markov Chain Options Callback - Ver 2.1.6
function chatbot_chatgpt_markov_chain_section_callback($args) {

    // See if the scanner needs to run
    $results = chatbot_chatgpt_markov_chain_build_results_callback(esc_attr(get_option('chatbot_chatgpt_markov_chain_build_schedule')));

    ?>
    <p>Configure the settings for the plugin when using Markov Chain models. Some example shortcodes include:</p>
    <ul style="list-style-type: disc; list-style-position: inside; padding-left: 1em;">
        <li><code>&#91;chatbot style="floating" model="markov-chain-2023-09-17"&#93;</code> - Style is floating, specific model</li>
        <li><code>&#91;chatbot style="embedded" model="markov-chain-2023-09-17"&#93;</code> - Style is embedded, specific model</li>
    </ul>
    <p>Markov Chain models generate text using a local algorithm based on the <a href="https://en.wikipedia.org/wiki/Markov_chain" target="_blank" rel="noopener noreferrer">Markov Chain</a> concept. They are trained on your site's published content, including pages, posts, and comments. These models run locally on your server and are not available on the OpenAI platform. While they can produce useful text, they are less advanced than OpenAI models and may sometimes generate nonsensical output. However, they can still be effective when your site has a large amount of content.</p> 
    <?php
}

// Markov Chain Enable Settings Callback - Ver 2.1.6
function chatbot_chatgpt_markov_chain_enabled_callback($args) {
    // Get the saved chatbot_chatgpt_markov_chain_enabled value or default to "No"
    $model_choice = esc_attr(get_option('chatbot_chatgpt_model_choice', 'gpt-3.5-turbo'));
    $markov_chain_enabled = esc_attr(get_option('chatbot_chatgpt_markov_chain_enabled', 'No'));
    if ($model_choice == 'markov-chain-2023-09-17' || $markov_chain_enabled == 'Yes') {
        $markov_chain_enabled = 'Yes';
        update_option('chatbot_chatgpt_markov_chain_enabled', 'Yes');
        update_option('chatbot_chatgpt_model_choice', 'markov-chain-2023-09-17');
    } else {
        $markov_chain_enabled = 'No';
        update_option('chatbot_chatgpt_markov_chain_enabled', 'No');
    }
    ?>
    <select id="chatbot_chatgpt_markov_chain_enabled" name="chatbot_chatgpt_markov_chain_enabled">
        <option value="Yes" <?php selected($markov_chain_enabled, 'Yes'); ?>>Yes</option>
        <option value="No" <?php selected($markov_chain_enabled, 'No'); ?>>No</option>
    </select>
    <?php
}

// Markov Chain Length Options Callback - Ver 2.1.6
function chatbot_chatgpt_markov_chain_length_callback($args) {
    // Get the saved chatbot_chatgpt_markov_chain_length_setting value or default to 10
    $markov_chain_length = esc_attr(get_option('chatbot_chatgpt_markov_chain_length', '2'));
    // Allow for a range of tokens between 1 and 10 in 1-step increments - Ver 2.1.6
    ?>
    <select id="chatbot_chatgpt_markov_chain_length" name="chatbot_chatgpt_markov_chain_length">
        <?php
        for ($i=1; $i<=10; $i+=1) {
            echo '<option value="' . esc_attr($i) . '" ' . selected($markov_chain_length, (string)$i, false) . '>' . esc_html($i) . '</option>';
        }
        ?>
    </select>
    <?php
}

// Markov Chain Next Phrase Length Settings Callback - Ver 2.1.6
function chatbot_chatgpt_markov_chain_next_phrase_length_callback($args) {
    // Get the saved chatbot_chatgpt_markov_chain_next_phrase_length_setting value or default to 10
    $markov_chain_next_phrase_length = esc_attr(get_option('chatbot_chatgpt_markov_chain_next_phrase_length', '2'));
    // Allow for a range of tokens between 10 and 1000 in 10-step increments - Ver 2.1.6
    ?>
    <select id="chatbot_chatgpt_markov_chain_next_phrase_length" name="chatbot_chatgpt_markov_chain_next_phrase_length">
        <?php
        for ($i=1; $i<=10; $i+=1) {
            echo '<option value="' . esc_attr($i) . '" ' . selected($markov_chain_next_phrase_length, (string)$i, false) . '>' . esc_html($i) . '</option>';
        }
        ?>
    </select>
    <?php
}

// Markov Chain Build Schedule Callback - Ver 2.1.6
function chatbot_chatgpt_markov_chain_build_schedule_callback($args) {

    // Get the saved chatbot_chatgpt_markov_chain_build_schedule value or default to "No"
    $chatbot_chatgpt_markov_chain_build_schedule = esc_attr(get_option('chatbot_chatgpt_markov_chain_build_schedule', 'No'));
    
    $options = [
        'No' => 'No',
        'Now' => 'Now',
        'Hourly' => 'Hourly',
        'Twice Daily' => 'Twice Daily',
        'Daily' => 'Daily',
        'Weekly' => 'Weekly',
        'Disable' => 'Disable',
        'Cancel' => 'Cancel'
    ];
    ?>
    <select id="chatbot_chatgpt_markov_chain_build_schedule" name="chatbot_chatgpt_markov_chain_build_schedule">
        <?php foreach ($options as $value => $label) : ?>
            <option value="<?php echo esc_attr($value); ?>" <?php selected($chatbot_chatgpt_markov_chain_build_schedule, $value); ?>>
                <?php echo esc_html($label); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <?php
    
    // DIAG - Diagnostics - Ver 2.1.6
    back_trace( 'NOTICE', 'chatbot_chatgpt_markov_chain_build_schedule: ' . $chatbot_chatgpt_markov_chain_build_schedule );
    
}

