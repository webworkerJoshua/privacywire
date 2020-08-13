import babel from '@rollup/plugin-babel';
import postcss from 'rollup-plugin-postcss';
import { terser } from 'rollup-plugin-terser';
import ignoreImport from 'rollup-plugin-ignore-import';
import resolve from '@rollup/plugin-node-resolve';
import commonjs from '@rollup/plugin-commonjs';

const production = !process.env.ROLLUP_WATCH;

export default [
  {
    // Normal PrivacyWire JS Frontend File
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
  },
  {
    // Unstyled PrivacyWire JS Frontend File
    input: 'src/js/PrivacyWire.js',
    output: {
      file: 'js/PrivacyWireUnstyled.js',
      format: 'iife',
      compact: true
    },
    plugins: [
      ignoreImport({
        extensions: ['.scss']
      }),
      babel({
        exclude: 'node_modules/**',
      }),
      production && terser()
    ],
  },
  // {
  //   // Admin PrivacyWire JS Backend FileExternal Media Cookies
  //   input: 'src/js/PrivacyWireAdmin.js',
  //   output: {
  //     file: 'js/PrivacyWireAdmin.js',
  //     format: 'iife',
  //     compact: true
  //   },
  //   plugins: [
  //     resolve(),
  //     commonjs(),
  //     babel({
  //       exclude: 'node_modules/**',
  //     }),
  //     production && terser()
  //   ],
  // },
];
