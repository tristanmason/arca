'use strict'

module.exports = ctx => {
  return {
    map: ctx.file.dirname.includes('examples') ?
      false :
      {
        inline: false,
        annotation: true,
        sourcesContent: true
      },
    plugins: {
      autoprefixer: {
        cascade: false
      },
	  "postcss-understrap-palette-generator" : {
		colors: [
			"--bs-purple",
      "--bs-gray",
      "--bs-purple-dark",
      "--bs-purple-light",
      "--bs-gray-dark",
      "--bs-gray-light",
			"--bs-text",
      "--bs-black",
      "--bs-white",
			"--bs-green",
      "--bs-blue",
			"--bs-teal",
      "--bs-gold",
      "--bs-red"
		]
	  }
    }
  }
}