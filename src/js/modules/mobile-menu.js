import { initMobileMenuSliding } from './mobile-menu-sliding.js';

/**
 * Accordion-style mobile submenu.
 * Inserts an "Overview" link at the top of each submenu so the parent
 * page remains navigable when the accordion is open.
 */
export function initMobileMenuAccordion() {
	const menuItems = document.querySelectorAll( '.c-mobile-menu .menu-item-has-children' );
	if ( ! menuItems.length ) return;

	menuItems.forEach( ( menuItem ) => {
		const link    = menuItem.querySelector( 'a' );
		const submenu = menuItem.querySelector( '.sub-menu' );
		if ( ! link || ! submenu ) return;

		// Add an "Overview" link so the parent page is still reachable
		const overviewLink = link.cloneNode( true );
		overviewLink.textContent = link.textContent.trim() + ' Overview';
		submenu.insertBefore( overviewLink, submenu.firstChild );

		link.addEventListener( 'click', ( e ) => {
			e.preventDefault();

			// Collapse all sibling items (not ancestors / descendants)
			menuItems.forEach( ( other ) => {
				if (
					other !== menuItem &&
					! menuItem.contains( other ) &&
					! other.contains( menuItem )
				) {
					other.classList.remove( 'is-open' );
					const otherSub = other.querySelector( '.sub-menu' );
					if ( otherSub ) {
						otherSub.style.height = null;
						otherSub.classList.remove( 'open' );
					}
				}
			} );

			submenu.classList.toggle( 'open' );
			menuItem.classList.toggle( 'is-open' );
		} );
	} );
}

/**
 * Initialize mobile menu based on the style set in the modal wrapper.
 */
export function initMobileMenu() {
	const modalWrap = document.getElementById( 'modal-nav-wrap' );
	if ( ! modalWrap ) return;

	const menuStyle = modalWrap.getAttribute( 'data-menu-style' ) || 'accordion';

	if ( 'sliding' === menuStyle ) {
		initMobileMenuSliding();
	} else {
		initMobileMenuAccordion();
	}
}
