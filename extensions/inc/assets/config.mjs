export default function getConfig() {
  return {
    url: 'http://fresh-timberstrap.local',
    endpoint: '/wp-json/timberstrap/v1/fetch_content',
    post_types: [
        'page',
        'lc_block',
        'lc_section',
        'lc_partial',
        'lc_dynamic_template',
        'lc_snippets'
    ],
    directories: [
        'template-livecanvas-blocks',
        'template-livecanvas-sections',
        'template-livecanvas-partials',
        'template-livecanvas-dynamic-templates',
        'template-livecanvas-snippets'
    ],
  };
}