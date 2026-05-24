/**
 * Sliding panel mobile menu.
 * Submenus slide in from the right, and parent links are duplicated
 * at the top of each submenu level.
 */
export function initMobileMenuSliding() {
	const menuItems = document.querySelectorAll( '.c-mobile-menu .menu-item-has-children' );
	if ( ! menuItems.length ) return;

	menuItems.forEach( ( menuItem ) => {
		const link    = menuItem.querySelector( 'a' );
		const submenu = menuItem.querySelector( '.sub-menu' );
		if ( ! link || ! submenu ) return;

		// Clone the parent link and insert at the top of submenu
		const clonedLink = link.cloneNode( true );
		submenu.insertBefore( clonedLink, submenu.firstChild );

		// Add click event to slide submenu open
		link.addEventListener( 'click', ( e ) => {
			e.preventDefault();
			submenu.classList.add( 'open' );
		} );

		// Create and add back button
		const backButton = document.createElement( 'button' );
		backButton.classList.add( 'c-submenu-back-button' );
		backButton.setAttribute( 'aria-label', 'Back to previous menu' );
		
		// Add SVG icon for back button
		const svgIcon = document.createElementNS( 'http://www.w3.org/2000/svg', 'svg' );
		svgIcon.setAttribute( 'xmlns', 'http://www.w3.org/2000/svg' );
		svgIcon.setAttribute( 'width', '1em' );
		svgIcon.setAttribute( 'height', '1em' );
		svgIcon.setAttribute( 'viewBox', '0 0 24 24' );
		
		const path = document.createElementNS( 'http://www.w3.org/2000/svg', 'path' );
		path.setAttribute( 'fill', 'currentColor' );
		path.setAttribute( 'd', 'm16.41 18.16l-5.66-5.66l5.66-5.66l.7.71l-4.95 4.95l4.95 4.95zm-4 0L6.75 12.5l5.66-5.66l.7.71l-4.95 4.95l4.95 4.95z' );
		
		svgIcon.appendChild( path );
		backButton.appendChild( svgIcon );
		
		const buttonText = document.createTextNode( ' Back' );
		backButton.appendChild( buttonText );

		// Add back button click handler
		backButton.addEventListener( 'click', () => {
			submenu.classList.remove( 'open' );
		} );

		// Insert back button at the top of submenu
		submenu.insertBefore( backButton, submenu.firstChild );
	} );
}
