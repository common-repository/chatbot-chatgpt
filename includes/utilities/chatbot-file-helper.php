<?php
/**
 * Kognetiks Chatbot for WordPress - File Helper - Ver 2.0.3
 *
 * This file contains the code for uploading files as part
 * in support of Custom GPT Assistants via the Chatbot.
 *
 * @package chatbot-chatgpt
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die();
}

// Handle non-image attachments
function chatbot_chatgpt_text_attachment($prompt, $file_id, $beta_version) {

    // Set up the data payload
    $data = [
        'role' => 'user',
        'content' => [
            [
                'type' => 'text',
                'text' => $prompt,
            ]
        ],
    ];

    // Add the non-images files to the data payload
    if ( !empty($file_id && !empty($file_id[0]) )) {
        if ( $beta_version == 'assistants=v1' ) {
            // assistants=v1 - Ver 1.9.6 - 2024 04 24
            $data['file_ids'] = $file_id;
        } else {
            // assistants=v2 - Ver 1.9.6 - 2024 04 24
            $data = $data + [
                "attachments" => [],
            ];
            foreach ($file_id as $file_item) {
                // Skip invalid file_item entries
                if (substr($file_item, 0, 5) !== 'file-') {
                    continue;
                }
                $attachment = [
                    "file_id" => $file_item,
                    "tools" => [
                        ["type" => "file_search"]
                    ]
                ];
                // Add each attachment to the attachments array in the main data structure
                $data['attachments'][] = $attachment;
            }
        }
    }

    return $data;

}

// Handle image attachments
function chatbot_chatgpt_image_attachment($prompt, $file_id, $beta_version) {

    // Set up the data payload
    $data = [
        'role' => 'user',
    ];

    // Add the image files to the data payload
    if ( !empty($file_id && !empty($file_id[0]) )) {
        if ( $beta_version == 'assistants=v1' ) {
            // assistants=v1 - Ver 1.9.6 - 2024 04 24
            $data['file_ids'] = $file_id;
        } else {
            // assistants=v2 - Ver 1.9.6 - 2024 04 24
            $data = $data + [
                'content' => [],
            ];
            foreach ($file_id as $file_item) {
                // Skip invalid file_item entries
                if (substr($file_item, 0, 5) !== 'file-') {
                    continue;
                }
                $attachment = [
                    'type' => 'image_file',
                    'image_file' => [
                        'file_id' => $file_item,
                        'detail' => 'auto'
                    ]
                ];
                // Add each image attachment to the attachments array in the main data structure
                $data['content'][] = $attachment;
            }
        }
    }

    // Finish off with the text prompt
    $data['content'][] = [
            'type' => 'text',
            'text' => $prompt,
        ];

    return $data;

}
