/**
 * Traps keyboard focus within an element.
 *
 * @param {HTMLElement} element - Container to trap focus inside.
 * @returns {() => void} Cleanup function — call it to release the trap.
 */
export function trapFocus( element ) {
	const focusable = element.querySelectorAll(
		'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])'
	);

	if ( ! focusable.length ) return () => {};

	const first = focusable[ 0 ];
	const last  = focusable[ focusable.length - 1 ];

	function handleKeydown( e ) {
		if ( e.key !== 'Tab' ) return;

		if ( e.shiftKey ) {
			if ( document.activeElement === first ) {
				e.preventDefault();
				last.focus();
			}
		} else {
			if ( document.activeElement === last ) {
				e.preventDefault();
				first.focus();
			}
		}
	}

	element.addEventListener( 'keydown', handleKeydown );

	// Return a cleanup function so callers can release the trap
	return () => element.removeEventListener( 'keydown', handleKeydown );
}
