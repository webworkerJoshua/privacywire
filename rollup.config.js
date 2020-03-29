import resolve from '@rollup/plugin-node-resolve';
import commonjs from '@rollup/plugin-commonjs';
import babel from 'rollup-plugin-babel';
import { terser } from 'rollup-plugin-terser';
import postcss from 'rollup-plugin-postcss';

const production = !process.env.ROLLUP_WATCH;

export default {
  input: 'src/js/PrivacyWire.js',
  output: {
    file: 'js/PrivacyWire.js',
    format: 'iife',
    compact: true
  },
  plugins: [
    resolve(),
    postcss({
      minimize: true
    }),
    babel({
      exclude: 'node_modules/**',
    }),
    commonjs(),
    production && terser()
  ],
};
