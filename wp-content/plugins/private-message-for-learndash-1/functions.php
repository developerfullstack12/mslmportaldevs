<?php

/**
 * Get Messages per
 *
 * @param int   $conversation_id .
 * @param array $args .
 *        'limit'                 => -1  will retrieve all .
 *        'type'                  => NULL (available: course|private|group) .
 *        'sender_id'             => NULL the id of the sender .
 *        'is_read'               => NULL accepted values true|false (default NULL will retrieve all) .
 *        'created_at'            => NULL timestamp format . string that can parsed with strtotime() .
 *        'created_at_comparison' => '<=' . accepted values are '!=', '>', '>=', '<', '<=', '=' .
 *        'order'                 => 'ASC' .
 *        'orderby'               => 'created_at' @todo add more options (unique created_at).
 * @return (array|null)
 */
function ldpm_chat_get_messages( $conversation_id, $args = [] ) {

	if ( empty( $conversation_id ) ) {
		return null;
	}

	$messages = Learndash_Private_Message::get_messages_sql( $conversation_id, $args );

	return [
		'messages' => $messages,
		'count'    => count( $messages ),
	];
}

/**
 * Undocumented function
 *
 * @param int    $conversation_id  Id of the conversation.
 * @param int    $sender_id        Id of the sender.
 * @param string $message          Text of the message.
 * @return boolean true if created false if not
 */
function ldpm_chat_post_message( $conversation_id, $sender_id, $message ) {
	if ( empty( $conversation_id ) || empty( $sender_id ) || empty( $message ) ) {
		return false;
	}

	$chat_type = Learndash_Private_Message::get_type_by_conversation_id( $conversation_id );

	$message_json = json_encode(
		[
			'text'  => $message,
			'files' => [],
		]
	);

	return Learndash_Private_Message::post_message( $conversation_id, $sender_id, $chat_type, $message_json );
}
