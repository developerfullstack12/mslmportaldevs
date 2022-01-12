jQuery(document).ready(function ($) {
  const menu_button = document.getElementById('imm-chat-menu__button');
  const chat_content = document.getElementById('ldpm-chat-content');
  const chat_element = document.getElementById('ldpm-chat-container');
  const chat_sidebar = document.getElementById('ldpm-chat-sidebar');
  const chat_settings = document.getElementById('ldpm-chat-settings');

  // Functions
  function set_theme() {
    const is_classic = learndash_private_message_frontend.theme === 'classic';
    chat_element.classList.add(is_classic ? 'imm-theme-classic' : 'imm-theme-styled');
  }

  function toggleSidebar() {
    if (chat_sidebar.classList.contains('imm-chat-aside--is-hidden')) {
      chat_sidebar.classList.remove('imm-chat-aside--is-hidden');
    } else {
      chat_sidebar.classList.add('imm-chat-aside--is-hidden');
    }
  }

  function toggleSettings() {
    if (chat_settings.classList.contains('imm-chat-settings--is-hidden')) {
      chat_settings.classList.remove('imm-chat-settings--is-hidden');
    } else {
      chat_settings.classList.add('imm-chat-settings--is-hidden');
    }
  }

  function toggleBackdrop() {
    if (chat_content.classList.contains('imm-chat-content__backdrop')) {
      chat_content.classList.remove('imm-chat-content__backdrop');
    } else {
      chat_content.classList.add('imm-chat-content__backdrop');
    }
  }

  async function delete_message(id) {
    const form_data = new FormData();
    form_data.append('action', 'delete_message');
    form_data.append('nonce', learndash_private_message_frontend.nonce);
    if (!isNaN(id)) {
      form_data.append('message_id', id);
    }

    const response = await fetch(learndash_private_message_frontend.ajaxurl, {
      method: 'POST',
      credentials: 'same-origin',
      body: form_data,
    });
    const json = await response.json();
    return json;
  }

  function add_delete_message_events() {
    const buttons = document.querySelectorAll(
      '.imm-chat__message .imm-chat__message__delete__button'
    );

    buttons.forEach((button) => {
      button.addEventListener('click', async (event) => {
        const current = event.target;

        const message_id = 'id' in current.dataset ? current.dataset.id : null;
        await delete_message(message_id);
        await load_active_conversation();
      });
    });
  }

  function sort_conversations_by_notifications(html) {
    let unread_conversations = [];
    const conversations_element = document.querySelector('#conversations');
    const temp_conversations = document.createElement('div');
    temp_conversations.id = 'unread_converations';
    temp_conversations.innerHTML = html;

    const conversations_with_notifications = temp_conversations.querySelectorAll(
      '.imm-group__item .imm-group__item__notifications'
    );
    conversations_with_notifications.forEach(function (element) {
      unread_conversations.push(element.closest('.imm-group__item'));
    });
    temp_conversations.remove();

    if (unread_conversations.length === 0) {
      return;
    }

    let unread_html =
      '<div class="imm-group"><div class="imm-group__title">Unread Messages</div><div class="imm-chat-paper imm-group__items">';
    for (let i = 0; i < unread_conversations.length; i++) {
      const current = unread_conversations[i];
      unread_html += current.outerHTML;
    }
    unread_html += '</div></div>';
    conversations_element.innerHTML = unread_html + conversations_element.innerHTML;
  }

  async function load_conversations() {
    const conversations_element = $('#conversations');

    const active_opponent = $('.ldpm-conversation-link.active');

    const form_data = new FormData();
    form_data.append('action', 'load_conversations');
    form_data.append('nonce', learndash_private_message_frontend.nonce);
    form_data.append('course_id', conversations_element.data('course-id'));

    if (active_opponent.length !== 0) {
      form_data.append('chat_type', active_opponent.data('type'));
      form_data.append('chat_entity_id', active_opponent.data('id'));
    }
    const response = await fetch(learndash_private_message_frontend.ajaxurl, {
      method: 'POST',
      credentials: 'same-origin',
      body: form_data,
    });
    const json = await response.json();

    if (json.success) {
      conversations_element.html(json.data);
      sort_conversations_by_notifications(json.data);

      if (active_opponent.length !== 0) {
        let active_conversation = null;
        if (active_opponent.data('limit-to-user-id')) {
          active_conversation = $(
            '.ldpm-conversation-link[data-type="' +
              active_opponent.data('type') +
              '"][data-id="' +
              active_opponent.data('id') +
              '"][data-limit-to-user-id="' +
              active_opponent.data('limit-to-user-id') +
              '"]'
          );
        } else {
          active_conversation = $(
            '.ldpm-conversation-link[data-type="' +
              active_opponent.data('type') +
              '"][data-id="' +
              active_opponent.data('id') +
              '"]'
          );
        }

        active_conversation.addClass('active');
      } else {
        const course_id = conversations_element.data('course-id');

        const query_string = window.location.search;
        const url_params = new URLSearchParams(query_string);

        if (course_id) {
          const available_conversation = document.querySelector(
            '#conversations .ldpm-conversation-link[data-id="' + course_id + '"]'
          );

          if (available_conversation) {
            available_conversation.classList.add('active');
            load_conversation_title(available_conversation);
            await load_active_conversation();
          }
        } else if (
          url_params.has('conversation_id') &&
          !isNaN(parseInt(url_params.get('conversation_id'), 10))
        ) {
          const current_conversation_id = parseInt(url_params.get('conversation_id'), 10);
          const available_conversation = document.querySelector(
            '#conversations .ldpm-conversation-link[data-id="' + current_conversation_id + '"]'
          );

          if (available_conversation) {
            available_conversation.classList.add('active');
            load_conversation_title(available_conversation);
            await load_active_conversation();
          }
        }
      }
    }
  }

  async function load_active_conversation() {
    const active_opponent = $('.ldpm-conversation-link.active');
    let invitation_accepted = false;
    if (active_opponent.length === 0) {
      return;
    }
    const current_id = active_opponent.data('id');
    const current_type = active_opponent.data('type');

    if (current_type === 'private_group') {
      const valid_response = await validate_user_invitation(current_id);
      if (valid_response.data === 'accepted') {
        invitation_accepted = true;
        close_private_group_invitation();
      } else {
        invitation_accepted = false;
      }
    } else {
      invitation_accepted = true;
    }

    if (invitation_accepted) {
      const form_data = new FormData();
      form_data.append('action', 'load_conversation');
      form_data.append('nonce', learndash_private_message_frontend.nonce);
      form_data.append('type', current_type);
      form_data.append('id', current_id);
      form_data.append('limited_to_user_id', active_opponent.data('limit-to-user-id') ?? '');

      const response = await fetch(learndash_private_message_frontend.ajaxurl, {
        method: 'POST',
        credentials: 'same-origin',
        body: form_data,
      });
      const json = await response.json();
      if (json.success) {
        $('#ldpm-chat__message-box__container').css('display', '');

        $('#chat-history').html(json.data);

        const chat_conversation = $('#chat-history div');
        chat_conversation.scrollTop(chat_conversation.prop('scrollHeight'));

        add_delete_message_events();

        await load_conversations();
        show_group_details_button(current_type === 'private_group');
      }
    } else {
      show_private_group_invitation(current_id);
    }
  }

  async function send_message(message, file) {
    const active_opponent = $('.ldpm-conversation-link.active');

    const form_data = new FormData();

    form_data.append('action', 'send_message');
    form_data.append('nonce', learndash_private_message_frontend.nonce);

    form_data.append('message', message);
    form_data.append('chat_type', active_opponent.data('type'));
    form_data.append('chat_entity_id', active_opponent.data('id'));
    form_data.append('limited_to_user_id', active_opponent.data('limit-to-user-id') ?? '');

    if (file !== undefined) {
      form_data.append('file', file);
    }

    const response = await fetch(learndash_private_message_frontend.ajaxurl, {
      method: 'POST',
      credentials: 'same-origin',
      body: form_data,
    });
    const json = await response.json();

    if (json.success) {
      $('#ldpm-message-to-send').val('');
      $('#ldpm-file-to-send').val('');

      $('#ldpm-chat-attached-file-indicator').css('display', '');

      await load_active_conversation();
    }
  }

  function load_conversation_title(event = null) {
    const title_element = document.getElementById('imm-chat-menu__title');
    if (!event) {
      title_element.innerHTML = '';
    } else {
      const current_title = event.querySelector('.imm-group__item__name');
      title_element.innerHTML = current_title.innerHTML;
    }
  }

  function resize_chat_for_small_container() {
    const chat_container = document.getElementById('ldpm-chat-container');
    if (chat_container.offsetWidth <= 768) {
      chat_container.classList.add('imm-chat--is-small');
    }
  }

  // Event handlers
  $(document).on('keypress', function (e) {
    if (e.which === 13 && !e.shiftKey) {
      // Enter
      $('#ldpm-send-message').click();
    }
  });

  $(document).on('submit', '#ldpm-chat-form', function (e) {
    e.preventDefault();

    const message = $('#ldpm-message-to-send').val().trim();
    const file = $('#ldpm-file-to-send').prop('files')[0];

    if (message.length === 0 && file === undefined) {
      return;
    }

    if (file !== undefined) {
      const file_extension = file.name.substring(file.name.lastIndexOf('.') + 1);

      // TODO: make customizable
      const valid_extensions = [
        'jpg',
        'pdf',
        'jpeg',
        'gif',
        'png',
        'doc',
        'docx',
        'xls',
        'xlsx',
        'ppt',
        'pptx',
        'txt',
        'zip',
        'rar',
        'gzip',
      ];

      if ($.inArray(file_extension, valid_extensions) === -1) {
        alert('File type is not allowed!');

        return;
      } else if (file.size > learndash_private_message_frontend.max_upload_size) {
        alert('File size is too large!');

        return;
      }
    }

    send_message(message, file);
  });

  $('#ldpm-file-to-send').on('change', function (e) {
    const file = $(this).prop('files')[0];

    if (file !== undefined) {
      $('#ldpm-chat-add-file').addClass('imm-text-yellow-400');
      $('#ldpm-chat-attached-file-indicator').css('display', 'flex');
    } else {
      $('#ldpm-chat-add-file').removeClass('imm-text-yellow-400');
      $('#ldpm-chat-attached-file-indicator').css('display', '');
    }
  });

  $(document).on('click', '.ldpm-conversation-link', async function (e) {
    e.preventDefault();

    $('.ldpm-conversation-link').removeClass('active');

    $(this).addClass('active');

    load_conversation_title(this);
    if (chat_content.classList.contains('imm-chat-content__backdrop')) {
      toggleSidebar();
      toggleBackdrop();
    }

    await load_conversations();
    await load_active_conversation();
  });

  $('#ldpm-chat-add-file').on('click', function () {
    $('#ldpm-file-to-send').trigger('click');
  });

  $(document).ajaxSend(function () {
    $('.ldpm-chat-syncing-indicator').removeClass('imm-hidden');
  });

  $(document).ajaxStop(function () {
    setTimeout(function () {
      $('.ldpm-chat-syncing-indicator').addClass('imm-hidden');
    }, 1500);
  });

  menu_button.addEventListener('click', function () {
    toggleSidebar();
    toggleBackdrop();
  });
  chat_content.addEventListener('click', function (event) {
    const current_status = event.target;
    if (current_status.classList.contains('imm-chat-content__backdrop')) {
      if (!chat_settings.classList.contains('imm-chat-settings--is-hidden')) {
        toggleSettings();
      }
      if (!chat_sidebar.classList.contains('imm-chat-aside--is-hidden')) {
        toggleSidebar();
      }
      if (!pg_dialog.classList.contains('imm-pg-dialog--is-hidden')) {
        close_pg_dialog();
      }
      if (!pg_group_details.classList.contains('imm-pg-details--is-hidden')) {
        toggle_group_details();
      }
      toggleBackdrop();
    }
  });

  // Search handler
  const search_input = document.getElementById('imm-search-input');
  let all_conversations = [];

  search_input.addEventListener('keyup', function (event) {
    const value = event.target.value;
    const new_regex = new RegExp(value, 'i');

    if (all_conversations.length === 0) {
      all_conversations = document.querySelectorAll('#conversations .imm-group__item');
    }

    all_conversations.forEach((conversation) => {
      const group_name = conversation.querySelector('.imm-group__item__name').innerText;

      if (new_regex.test(group_name)) {
        conversation.style.display = '';
      } else {
        conversation.style.display = 'none';
      }
    });
  });

  const settings_close_button = document.getElementById('imm-chat-settings__close-button');
  const settings_button = document.getElementById('imm-chat-settings__button');

  settings_button.addEventListener('click', function () {
    toggleSettings();
    toggleBackdrop();
  });

  settings_close_button.addEventListener('click', function () {
    toggleSettings();
    toggleBackdrop();
  });

  const settings_checkboxes = document.querySelectorAll('.imm-chat-settings__label input');
  settings_checkboxes.forEach(function (checkbox) {
    checkbox.addEventListener('change', function (event) {
      const option_name = event.target.name;
      const option_value = event.target.checked;

      let form_data = new FormData();

      form_data.append('action', 'update_settings');
      form_data.append('nonce', learndash_private_message_frontend.nonce);

      form_data.append('option', option_name);
      form_data.append('value', option_value);

      $.ajax({
        type: 'post',
        url: learndash_private_message_frontend.ajaxurl,
        data: form_data,
        contentType: false,
        processData: false,
        success: function (response) {},
      });
    });
  });

  // Run on document ready
  set_theme();
  load_conversations();
  resize_chat_for_small_container();

  setInterval(async function () {
    await load_conversations();
    await load_active_conversation();
  }, 1000 * learndash_private_message_frontend.chat_refresh_frequency_seconds);

  // Private Group Dialog. pg = private group
  const pg_show_dialog_button = document.getElementById('ldpm-pg-show-dialog-button');
  const pg_dialog = document.getElementById('ldpm-pg-dialog');
  const pg_cancel_button = document.getElementById('ldpm-pg-cancel');
  const pg_create_button = document.getElementById('ldpm-pg-create');
  const pg_name_input = document.getElementById('ldpm-pg-name-input');
  const pg_invited_select = document.getElementById('ldpm-pg-invited-id-select');
  const pg_invite_button = document.getElementById('ldpm-pg-invite-button');
  const pg_invited_datalist = document.getElementById('ldpm-pg-invited-ids-datalist');
  const pg_invited_ids_content = document.getElementById('ldpm-pg-invited-ids-content');
  const pg_invitation_form = document.getElementById('ldpm-chat-private-invitation-form');
  const pg_invitation_accept_button = document.getElementById(
    'ldpm-chat-private-invitation-accept'
  );
  const pg_invitation_decline_button = document.getElementById(
    'ldpm-chat-private-invitation-decline'
  );
  const pg_show_details_button = document.getElementById('imm-pg-show-details__button');
  const pg_group_details = document.getElementById('ldpm-pg-details');
  const pg_close_details_button = document.getElementById('imm-pg-details__close-button');
  const pg_leave_group_button = document.getElementById('ldpm-pg-leave-group');
  const pg_delete_group_button = document.getElementById('ldpm-pg-delete-group');
  let invited_ids = [];

  // Display Functions

  function show_options_on_select(members) {
    while (pg_invited_datalist.options.length !== 0) {
      pg_invited_datalist.remove(pg_invited_datalist.options.length - 1);
    }

    let new_options = '';
    members.forEach((member) => {
      new_options += '<option data-value="' + member.id + '" value="' + member.name + '"></option>';
    });

    pg_invited_datalist.innerHTML = new_options;
  }

  function remove_id_from_invited(event) {
    const current_button = event.target;
    const container = current_button.closest('div[data-id]');
    const current_id = parseInt(container.dataset.id, 10);

    invited_ids = invited_ids.filter((node) => node.id !== current_id);
    container.remove();
  }

  function show_members_in_list() {
    pg_invited_ids_content.innerHTML = '';
    for (let i = 0; i < invited_ids.length; i++) {
      const current = invited_ids[i];

      const container = document.createElement('div');
      container.classList.add('imm-pg-list__item');
      container.dataset.id = current.id;

      const textnode = document.createTextNode(current.name);
      const text = document.createElement('span');
      text.appendChild(textnode);
      container.appendChild(text);

      const buttonnode = document.createTextNode('remove');
      const button = document.createElement('button');
      button.classList.add('imm-pg-button', 'imm-pg-button--is-cancel', 'imm-pg-button--is-small');
      button.appendChild(buttonnode);
      button.addEventListener('click', remove_id_from_invited);
      container.appendChild(button);

      pg_invited_ids_content.insertAdjacentElement('beforeend', container);
    }
  }

  function close_pg_dialog() {
    pg_name_input.value = '';
    invited_ids = [];
    pg_invited_datalist.innerHTML = '';
    pg_invited_ids_content.innerHTML = '';
    pg_dialog.classList.add('imm-pg-dialog--is-hidden');
  }

  function show_private_group_invitation(conversation_id) {
    const chat_history = document.getElementById('chat-history');
    const chat_invitation = document.getElementById('ldpm-chat-private-invitation');

    if (!pg_invitation_form.contains(document.querySelector('input[name="conversation_id"]'))) {
      const conversation_input = document.createElement('input');
      conversation_input.setAttribute('type', 'hidden');
      conversation_input.setAttribute('name', 'conversation_id');
      conversation_input.setAttribute('value', conversation_id);

      pg_invitation_form.appendChild(conversation_input);
    }

    chat_history.style.display = 'none';
    chat_invitation.style.display = 'grid';
  }

  function close_private_group_invitation() {
    const chat_history = document.getElementById('chat-history');
    const chat_invitation = document.getElementById('ldpm-chat-private-invitation');
    const input = document.querySelector('input[name="conversation_id"]');

    if (pg_invitation_form.contains(input)) {
      input.remove();
    }

    chat_history.style.display = 'flex';
    chat_invitation.style.display = 'none';
  }

  function toggle_group_details() {
    if (pg_group_details.classList.contains('imm-pg-details--is-hidden')) {
      pg_group_details.classList.remove('imm-pg-details--is-hidden');
    } else {
      pg_group_details.classList.add('imm-pg-details--is-hidden');
    }
  }

  function show_group_details_button(should_open = true) {
    pg_show_details_button.parentElement.style.display = should_open ? 'block' : 'none';
  }

  function fill_group_details_members(members) {
    const list = pg_group_details.querySelector('.imm-pg-details__members');

    list.innerHTML = '';
    let html = '';
    for (let i = 0; i < members.length; i++) {
      const member = members[i];
      html += '<div class="imm-pg-details__member">' + member.display_name + '</div>';
    }

    list.innerHTML = html;
  }

  // Callbacks Functions
  async function get_available_members(id) {
    const form_data = new FormData();
    form_data.append('action', 'get_available_members');
    form_data.append('nonce', learndash_private_message_frontend.nonce);

    const response = await fetch(learndash_private_message_frontend.ajaxurl, {
      method: 'POST',
      credentials: 'same-origin',
      body: form_data,
    });
    const json = await response.json();
    return json;
  }

  async function get_members_of_conversation(id) {
    const form_data = new FormData();
    form_data.append('action', 'get_members_of_conversation');
    form_data.append('nonce', learndash_private_message_frontend.nonce);
    form_data.append('conversation_id', id);

    const response = await fetch(learndash_private_message_frontend.ajaxurl, {
      method: 'POST',
      credentials: 'same-origin',
      body: form_data,
    });
    const json = await response.json();
    return json;
  }

  async function is_group_leader(id) {
    const form_data = new FormData();
    form_data.append('action', 'is_group_leader');
    form_data.append('nonce', learndash_private_message_frontend.nonce);
    form_data.append('conversation_id', id);

    const response = await fetch(learndash_private_message_frontend.ajaxurl, {
      method: 'POST',
      credentials: 'same-origin',
      body: form_data,
    });
    const json = await response.json();
    return json;
  }

  async function leave_private_group(id) {
    const form_data = new FormData();
    form_data.append('action', 'leave_private_group');
    form_data.append('nonce', learndash_private_message_frontend.nonce);
    form_data.append('conversation_id', id);

    const response = await fetch(learndash_private_message_frontend.ajaxurl, {
      method: 'POST',
      credentials: 'same-origin',
      body: form_data,
    });
    const json = await response.json();
    return json;
  }

  async function delete_private_group(id) {
    const form_data = new FormData();
    form_data.append('action', 'delete_private_group');
    form_data.append('nonce', learndash_private_message_frontend.nonce);
    form_data.append('conversation_id', id);

    const response = await fetch(learndash_private_message_frontend.ajaxurl, {
      method: 'POST',
      credentials: 'same-origin',
      body: form_data,
    });
    const json = await response.json();
    return json;
  }

  async function respond_to_invitation(conversation_id, user_response) {
    const form_data = new FormData();
    form_data.append('action', 'respond_to_invitation');
    form_data.append('nonce', learndash_private_message_frontend.nonce);
    form_data.append('conversation_id', conversation_id);
    form_data.append('response', user_response);

    const response = await fetch(learndash_private_message_frontend.ajaxurl, {
      method: 'POST',
      credentials: 'same-origin',
      body: form_data,
    });
    const json = await response.json();
    return json;
  }

  async function invite_members_to_private_groups(ids) {
    const form_data = new FormData();
    form_data.append('action', 'invite_members_to_private_groups');
    form_data.append('nonce', learndash_private_message_frontend.nonce);

    const response = await fetch(learndash_private_message_frontend.ajaxurl, {
      method: 'POST',
      credentials: 'same-origin',
      body: form_data,
    });
    const json = await response.json();
    return json;
  }

  async function create_private_group(name, ids) {
    const form_data = new FormData();
    form_data.append('action', 'create_private_group');
    form_data.append('nonce', learndash_private_message_frontend.nonce);
    form_data.append('name', name);
    form_data.append('invited_ids', JSON.stringify(ids));

    const response = await fetch(learndash_private_message_frontend.ajaxurl, {
      method: 'POST',
      credentials: 'same-origin',
      body: form_data,
    });
    const json = await response.json();
    return json;
  }

  async function validate_user_invitation(conversation_id) {
    const form_data = new FormData();
    form_data.append('action', 'validate_user_invitation');
    form_data.append('nonce', learndash_private_message_frontend.nonce);
    form_data.append('conversation_id', conversation_id);

    const response = await fetch(learndash_private_message_frontend.ajaxurl, {
      method: 'POST',
      credentials: 'same-origin',
      body: form_data,
    });
    const json = await response.json();
    return json;
  }

  // Event listeners
  pg_cancel_button.addEventListener('click', close_pg_dialog);

  if (pg_show_dialog_button) {
    pg_show_dialog_button.addEventListener('click', async function () {
      pg_dialog.classList.remove('imm-pg-dialog--is-hidden');
      // closes sidebar
      chat_sidebar.classList.add('imm-chat-aside--is-hidden');

      // keeps open the backdrop
      if (!chat_content.classList.contains('imm-chat-content__backdrop')) {
        chat_content.classList.add('imm-chat-content__backdrop');
      }

      const members = await get_available_members();

      show_options_on_select(members.data);
    });
  }

  pg_invite_button.addEventListener('click', function () {
    const options = [].slice.call(pg_invited_datalist.options);
    const found = options.find((option) => option.value === pg_invited_select.value);
    const id = parseInt(found.dataset.value, 10);

    if (!id || isNaN(id)) {
      return;
    }

    const exists_element = invited_ids.some((current) => current.id === id);

    if (!exists_element) {
      invited_ids.push({ id: id, name: pg_invited_select.value });
      show_members_in_list();
      pg_invited_select.value = '';
    }
  });

  pg_create_button.addEventListener('click', async function () {
    const name = pg_name_input.value;
    const ids = invited_ids.map((node) => node.id);

    if (!name || ids.length === 0) {
      return;
    }
    const response = await create_private_group(name, ids);

    await load_conversations();
    const current_active = document.querySelector('.ldpm-conversation-link.active');

    if (current_active) {
      current_active.classList.remove('active');
    }

    if ('data' in response) {
      const new_group = document.querySelector(
        '.ldpm-conversation-link[data-id="' + response.data + '"]'
      );

      if (new_group) {
        new_group.classList.add('active');
        load_conversation_title(new_group);
        await load_active_conversation();
      }
    }
    close_pg_dialog();
    toggleBackdrop();
  });

  pg_invitation_accept_button.addEventListener('click', async function () {
    const form_data = new FormData(pg_invitation_form);

    const conversation_id = form_data.get('conversation_id');

    await respond_to_invitation(conversation_id, true);
    close_private_group_invitation();
    await load_active_conversation();
  });

  pg_invitation_decline_button.addEventListener('click', async function () {
    const form_data = new FormData(pg_invitation_form);

    const conversation_id = form_data.get('conversation_id');

    await respond_to_invitation(conversation_id, false);
    close_private_group_invitation();
    await load_conversations();
  });

  pg_show_details_button.addEventListener('click', async function () {
    toggle_group_details();
    toggleBackdrop();

    const active_conversation = document.querySelector('.ldpm-conversation-link.active');

    if (active_conversation) {
      const members = await get_members_of_conversation(active_conversation.dataset.id);
      const is_leader = await is_group_leader(active_conversation.dataset.id);

      if (is_leader.data) {
        pg_delete_group_button.style.display = 'block';
      } else {
        pg_delete_group_button.style.display = 'none';
      }
      fill_group_details_members(members.data);
    }
  });

  pg_close_details_button.addEventListener('click', function () {
    toggle_group_details();
    toggleBackdrop();
  });

  pg_leave_group_button.addEventListener('click', async function () {
    const active_conversation = document.querySelector('.ldpm-conversation-link.active');
    const chat_history = document.querySelector('#chat-history');
    const message_box = document.querySelector('#ldpm-chat__message-box__container');

    if (active_conversation) {
      await leave_private_group(active_conversation.dataset.id);
      active_conversation.classList.remove('active');
      await load_conversations();
      chat_history.innerHTML = '';
      message_box.style.display = 'none';
      load_conversation_title();
      show_group_details_button(false);
    }

    toggle_group_details();
    toggleBackdrop();
  });

  pg_delete_group_button.addEventListener('click', async function () {
    const active_conversation = document.querySelector('.ldpm-conversation-link.active');
    const chat_history = document.querySelector('#chat-history');
    const message_box = document.querySelector('#ldpm-chat__message-box__container');

    if (active_conversation) {
      await delete_private_group(active_conversation.dataset.id);
      active_conversation.classList.remove('active');
      await load_conversations();
      chat_history.innerHTML = '';
      message_box.style.display = 'none';
      load_conversation_title();
      show_group_details_button(false);
    }

    toggle_group_details();
    toggleBackdrop();
  });
});
