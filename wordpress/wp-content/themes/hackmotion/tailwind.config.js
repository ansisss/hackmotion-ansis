/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.php", "./src/**/*.html", "./src/**/*.js"],
  theme: {
    extend: {
      colors: {
        primary: { normal: "#5773FF", bg: "#E6E6E6" },
      },
      fontFamily: {
        ibm: ["IBM Plex Sans", "sans-serif"],
      },
    },
  },
  plugins: [],
};
