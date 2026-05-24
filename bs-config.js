/**
 * BrowserSync config for LaunchPad theme.
 * Proxies the Local by Flywheel site and watches compiled assets in build/.
 *
 * Run:  npm run bs
 */
module.exports = {
	proxy: 'https://launchai.local',
	https: {
		key: `${process.env.APPDATA}\\Local\\run\\router\\nginx\\certs\\launchai.local.key`,
		cert: `${process.env.APPDATA}\\Local\\run\\router\\nginx\\certs\\launchai.local.crt`,
	},
	files: [
		'build/**/*.css',
		'build/**/*.js',
		'**/*.php',
	],
	ignore: [
		'node_modules',
	],
	notify: false,
	open: true,
	ui: false,
};
