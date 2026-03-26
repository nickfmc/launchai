/**
 * AccessibilityWidget
 *
 * Wires up the floating accessibility panel rendered in footer.php.
 * Persists user preferences to localStorage.
 */
export default class AccessibilityWidget {
	constructor() {
		this.widget   = document.getElementById( 'a11y-widget' );
		this.popup    = document.getElementById( 'a11y-popup' );
		this.closeBtn = document.getElementById( 'a11y-close' );

		if ( ! this.widget || ! this.popup ) return;

		this.options = [
			{ id: 'a11y-high-contrast',  cls: 'a11y-high-contrast' },
			{ id: 'a11y-larger-text',    cls: 'a11y-larger-text' },
			{ id: 'a11y-reduced-motion', cls: 'a11y-reduced-motion' },
			{ id: 'a11y-focus-visible',  cls: 'a11y-focus-visible' },
		];

		this._restorePreferences();
		this._bindEvents();
	}

	_open() {
		this.popup.removeAttribute( 'inert' );
		this.popup.setAttribute( 'aria-hidden', 'false' );
		this.popup.classList.add( 'is-active' );
		this.widget.setAttribute( 'aria-expanded', 'true' );
		this.closeBtn && this.closeBtn.focus();
	}

	_close() {
		this.popup.setAttribute( 'inert', '' );
		this.popup.setAttribute( 'aria-hidden', 'true' );
		this.popup.classList.remove( 'is-active' );
		this.widget.setAttribute( 'aria-expanded', 'false' );
		this.widget.focus();
	}

	_toggle() {
		const isOpen = this.popup.classList.contains( 'is-active' );
		isOpen ? this._close() : this._open();
	}

	_bindEvents() {
		this.widget.addEventListener( 'click', () => this._toggle() );

		if ( this.closeBtn ) {
			this.closeBtn.addEventListener( 'click', () => this._close() );
		}

		// Close on Escape
		document.addEventListener( 'keydown', ( e ) => {
			if ( e.key === 'Escape' && this.popup.classList.contains( 'is-active' ) ) {
				this._close();
			}
		} );

		// Close on outside click
		document.addEventListener( 'click', ( e ) => {
			if (
				this.popup.classList.contains( 'is-active' ) &&
				! this.popup.contains( e.target ) &&
				! this.widget.contains( e.target )
			) {
				this._close();
			}
		} );

		// Wire checkboxes
		this.options.forEach( ( { id, cls } ) => {
			const input = document.getElementById( id );
			if ( ! input ) return;
			input.addEventListener( 'change', () => {
				document.body.classList.toggle( cls, input.checked );
				localStorage.setItem( `launchpad_${ id }`, input.checked );
			} );
		} );
	}

	_restorePreferences() {
		this.options.forEach( ( { id, cls } ) => {
			const stored = localStorage.getItem( `launchpad_${ id }` );
			if ( stored === 'true' ) {
				document.body.classList.add( cls );
				const input = document.getElementById( id );
				if ( input ) input.checked = true;
			}
		} );
	}
}
