/**
 * Keyboard-accessible dropdown menus for the main navigation.
 * Toggles .is-active on submenus and aria-expanded on toggle buttons.
 */
export function initDropdownMenu() {
	const buttons = document.querySelectorAll( '.dropdown-toggle' );
	if ( ! buttons.length ) return;

	buttons.forEach( ( button ) => {
		button.addEventListener( 'click', ( e ) => {
			e.preventDefault();
			const isExpanded = button.getAttribute( 'aria-expanded' ) === 'true';
			button.setAttribute( 'aria-expanded', String( ! isExpanded ) );

			const submenu = button.parentElement.querySelector( 'ul' );
			if ( submenu ) submenu.classList.toggle( 'is-active' );
		} );
	} );

	// Close all dropdowns when clicking outside the nav
	document.addEventListener( 'click', ( e ) => {
		if ( e.target.closest( '.menu-item-has-children' ) ) return;

		buttons.forEach( ( button ) => {
			button.setAttribute( 'aria-expanded', 'false' );
			const submenu = button.parentElement.querySelector( 'ul' );
			if ( submenu ) submenu.classList.remove( 'is-active' );
		} );
	} );
}
