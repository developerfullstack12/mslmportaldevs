jQuery(document).ready(function ($) {
  $('#ldpm_verify_key').on('click', function () {
    let key = $('#license_key').val();

    if (key.length !== 35) {
      alert('Please enter a valid license key');

      return false;
    }

    $.ajax({
      type: 'post',
      dataType: 'json',
      url: ajaxurl,
      data: {
        action: 'verify_license_key',
        license_key: key,
      },
      success: function (response) {
        if (response.success) {
          location.reload();
        } else {
          alert('Sorry, your key is not valid');
        }
      },
    });
  });

  $('#ldpm_disable_key').on('click', function () {
    $.ajax({
      type: 'post',
      dataType: 'json',
      url: ajaxurl,
      data: {
        action: 'disable_license_key',
      },
      success: function (response) {
        location.reload();
      },
    });
  });

  $('#ldpm_specific_courses').select2({
    width: '100%',
  });

  $('#ldpm_specific_groups').select2({
    width: '100%',
  });

  $('#ldpm-user-select')
    .select2({
      minimumInputLength: 1,
      ajax: {
        url: '/wp-json/wp/v2/users',
        dataType: 'json',
        delay: 500,
        data: (params) => ({
          search: params.term,
          page: params.page || 1,
          per_page: 100,
          orderby: 'name',
        }),
        processResults: function (data, params) {
          var terms = [];

          if (data) {
            $.each(data, function (index, user) {
              terms.push({ id: user.id, text: user.name });
            });
          }

          return {
            results: terms,
            pagination: {
              more: terms.length > 0,
            },
          };
        },
      },
    })
    .on('change', function () {
      const userId = $(this).val();

      $.ajax({
        type: 'post',
        dataType: 'json',
        url: ajaxurl,
        data: {
          action: 'load_user_messages',
          nonce: learndash_private_message_backend.nonce_messages_dashboard,
          user_id: userId,
        },
        success: function (response) {
          if (response.success) {
            $('#ldpm-user-messages').html(response.data).show();
          }
        },
      });
    });

  const private_chat_options_container = document.querySelector(
    'h2+div#ldpm_private_options+table'
  );
  const students_teacher_restriction_option = document.querySelector(
    'select[name="ldpm_restrict_chats_to_only_students_and_teachers"]'
  );

  const anonymous_users_option = document.querySelector(
    'select[name="ldpm_enable_anonymous_users"]'
  );

  if (
    private_chat_options_container &&
    students_teacher_restriction_option &&
    anonymous_users_option
  ) {
    function reset_private_options() {
      const private_chat_groups_option = document.querySelector(
        'select[name="ldpm_allow_create_private_chat_groups"]'
      );

      const delete_private_messages_option = document.querySelector(
        'select[name="ldpm_allow_to_delete_private_messages"]'
      );

      private_chat_groups_option.value = 0;
      delete_private_messages_option.value = 0;
    }

    const initial_checked = students_teacher_restriction_option.value;

    if (initial_checked === '1') {
      private_chat_options_container.style.display = 'none';
      reset_private_options();
      anonymous_users_option.closest('tr').style.display = '';
    } else {
      anonymous_users_option.closest('tr').style.display = 'none';
      anonymous_users_option.value = 0;
    }

    students_teacher_restriction_option.addEventListener('change', function (event) {
      const is_checked = event.target.value;
      if (is_checked === '0') {
        private_chat_options_container.style.display = 'block';
        anonymous_users_option.closest('tr').style.display = 'none';
        anonymous_users_option.value = 0;
      } else {
        private_chat_options_container.style.display = 'none';
        anonymous_users_option.closest('tr').style.display = '';
        reset_private_options();
      }
    });
  }

  const conversation_link_option = document.querySelector(
    'select[name="ldpm_include_conversation_links"]'
  );
  const conversation_link_textarea = document.querySelector(
    'textarea[name="ldpm_notification_email[conversation_link]"]'
  );

  if (conversation_link_option && conversation_link_textarea) {
    const initial_checked = conversation_link_option.value;
    if (initial_checked === '0') {
      conversation_link_textarea.closest('tr').style.display = 'none';
    }

    conversation_link_option.addEventListener('change', function (event) {
      const is_checked = event.target.value;
      if (is_checked === '0') {
        conversation_link_textarea.closest('tr').style.display = 'none';
      } else {
        conversation_link_textarea.closest('tr').style.display = '';
      }
    });
  }
});
