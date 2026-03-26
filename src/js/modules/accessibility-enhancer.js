/**
 * AccessibilityEnhancer
 *
 * Automatically adds aria-label notices and rel attributes to links that:
 * - open in a new tab
 * - point to an external domain
 * - link to a PDF file
 *
 * Also watches for dynamically added content via MutationObserver.
 */
export class AccessibilityEnhancer {
	constructor() {
		this.newTabText      = '(Opens in a new tab)';
		this.externalLinkText = '(External link)';
		this.pdfText         = '(PDF file)';
	}

	enhanceLinks() {
		document.querySelectorAll( 'a' ).forEach( ( link ) => this._enhance( link ) );
	}

	observe() {
		const observer = new MutationObserver( ( mutations ) => {
			mutations.forEach( ( mutation ) => {
				mutation.addedNodes.forEach( ( node ) => {
					if ( node.nodeType !== 1 ) return; // element nodes only
					if ( node.tagName === 'A' ) this._enhance( node );
					node.querySelectorAll( 'a' ).forEach( ( link ) => this._enhance( link ) );
				} );
			} );
		} );

		observer.observe( document.body, { childList: true, subtree: true } );
	}

	_enhance( link ) {
		const isNewTab   = link.target === '_blank' || link.target === 'blank';
		const isExternal = this._isExternal( link );
		const isPDF      = this._isPDF( link );

		const baseLabel = link.getAttribute( 'aria-label' ) || link.textContent.trim();
		let label = baseLabel;

		if ( isNewTab   && ! label.includes( this.newTabText ) )      label += ` ${ this.newTabText }`;
		if ( isExternal && ! label.includes( this.externalLinkText ) ) label += ` ${ this.externalLinkText }`;
		if ( isPDF      && ! label.includes( this.pdfText ) )         label += ` ${ this.pdfText }`;

		if ( label !== baseLabel ) link.setAttribute( 'aria-label', label.trim() );

		if ( isNewTab || isExternal ) {
			const rel = link.getAttribute( 'rel' ) || '';
			if ( ! rel.includes( 'noopener' ) ) {
				link.setAttribute( 'rel', ( rel + ' noopener noreferrer' ).trim() );
			}
		}
	}

	_isExternal( link ) {
		if ( ! link.href ) return false;
		try {
			return new URL( link.href ).hostname !== window.location.hostname;
		} catch {
			return false;
		}
	}

	_isPDF( link ) {
		if ( ! link.href ) return false;
		if ( link.href.toLowerCase().endsWith( '.pdf' ) ) return true;
		if ( link.type && link.type.toLowerCase() === 'application/pdf' ) return true;
		const dl = link.getAttribute( 'download' );
		return !! ( dl && dl.toLowerCase().endsWith( '.pdf' ) );
	}
}
