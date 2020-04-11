module.exports = {
	extends: [
		'nextcloud',
	],
	rules: {
		semi: [2, "always"]
	},
	globals: {
		expect: true,
		OC: true,
		OCA: true,
		OCP: true,
		t: true,
		__webpack_public_path__: true,
		__webpack_nonce__: true,
	}
}
