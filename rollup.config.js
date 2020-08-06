import babel from '@rollup/plugin-babel';
import postcss from 'rollup-plugin-postcss';
import { terser } from 'rollup-plugin-terser';

const production = !process.env.ROLLUP_WATCH;

export default {
  input: 'src/js/PrivacyWire.js',
  output: {
    file: 'js/PrivacyWire.js',
    format: 'iife',
    compact: true
  },
  plugins: [
    postcss({
      minimize: true
    }),
    babel({
      exclude: 'node_modules/**',
    }),
    production && terser()
  ],
};
