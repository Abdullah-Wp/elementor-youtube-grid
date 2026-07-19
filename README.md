# Elementor YouTube Grid (RSS)

An Elementor widget that displays recent videos from a public YouTube channel or playlist using YouTube's RSS feeds. It requires no YouTube API key and includes responsive controls, caching, lazy-loaded thumbnails, metadata, and lightbox support.

## Features

- Channel and playlist RSS sources.
- Responsive desktop, tablet, and mobile columns.
- Configurable feed caching.
- Lazy-loaded thumbnails with Elementor icon controls.
- YouTube, same-tab, or Elementor lightbox actions.
- Video title, publish date, and description controls.
- Aspect ratio, spacing, border, typography, overlay, and hover controls.
- Editor preview data when a source ID has not been configured.

## Requirements

- WordPress 6.0 or newer.
- PHP 7.4 or newer with SimpleXML.
- Elementor.
- Outbound HTTPS access to YouTube.

## Installation

1. Download the latest release ZIP.
2. In WordPress, open **Plugins > Add New > Upload Plugin**.
3. Upload and activate the plugin.
4. Edit a page with Elementor.
5. Add **YouTube Grid (RSS)** and enter a channel or playlist ID.

## Caching

RSS responses are stored in WordPress transients using the lifetime selected in the widget. A cached response reduces repeated requests to YouTube. Setting the cache lifetime to zero disables transient caching.

## External service and privacy

The plugin requests public RSS data from `youtube.com`, thumbnails from YouTube's image hosts, and embedded videos from YouTube when visitors open a lightbox. Those requests can disclose visitor information such as IP address and browser headers to YouTube. Site owners should document this behavior in their privacy policy and obtain consent where required.

Review [YouTube's Terms of Service](https://www.youtube.com/static?template=terms) and [Google's Privacy Policy](https://policies.google.com/privacy).

## Development

Run syntax checks with:

```text
php -l elementor-youtube-grid.php
php -l widgets/class-youtube-grid-rss.php
node --check assets/js/yt-grid-rss.js
```

## License

GPL-2.0-or-later. See [LICENSE](LICENSE).
