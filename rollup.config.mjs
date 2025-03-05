import babel from "@rollup/plugin-babel";
import terser from "@rollup/plugin-terser";
import copy from "rollup-plugin-copy";
import ignoreImport from "rollup-plugin-ignore-import";
import postcss from "rollup-plugin-postcss";

const production = !process.env.ROLLUP_WATCH;

export default [
	{
		// ES6 PrivacyWire JS Frontend File
		input: "src/js/PrivacyWire.js",
		output: {
			file: "js/PrivacyWire.js",
			format: "iife",
			compact: true,
		},
		plugins: [
			postcss({
				minimize: true,
				extract: "PrivacyWire.css",
			}),
			production &&
				terser({
					keep_classnames: true,
					keep_fnames: true,
				}),
		],
	},
	{
		// Regular PrivacyWire JS Frontend File
		input: "src/js/PrivacyWire.js",
		output: {
			file: "js/PrivacyWire_legacy.js",
			format: "iife",
			compact: true,
		},
		plugins: [
			ignoreImport({
				extensions: [".css"],
			}),
			babel({
				exclude: "node_modules/**",
				babelHelpers: "bundled",
			}),
			copy({
				targets: [
					{
						src: "js/PrivacyWire.css",
						dest: "css/",
					},
				],
			}),
			production &&
				terser({
					keep_classnames: true,
					keep_fnames: true,
				}),
		],
	},
];
