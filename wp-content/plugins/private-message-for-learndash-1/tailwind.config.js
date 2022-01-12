module.exports = {
  purge: [
    './includes/class-learndash-private-message.php',
    './public/partials/learndash-private-message-public-display.php',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {},
  },
  variants: {
    extend: {},
  },
  plugins: [],
  corePlugins: {
    preflight: false,
  },
  prefix: 'imm-',
};
