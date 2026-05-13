import re

files = ['calidad.blade.php', 'reportar.blade.php', 'alertas.blade.php', 'estandares.blade.php']
for file in files:
    with open('resources/views/' + file, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Extract Title
    title_match = re.search(r'<title>(.*?)</title>', content)
    title = title_match.group(1) if title_match else 'HidroVida'
    
    # Extract Custom Styles
    styles_match = re.search(r'\.btn-register:hover \{[\s\S]*?transform: scale\(1\.05\);[\s\S]*?\}([\s\S]*?)</style>', content)
    if styles_match:
        custom_styles = styles_match.group(1).strip()
    else:
        custom_styles = ''
    
    # Extract main content (everything after </header> up to vue-components-wrapper or script tags)
    main_split = content.split('</header>')
    if len(main_split) > 1:
        main_content = main_split[1]
        
        # Remove vue wrapper if it exists in the child (it's now in the layout)
        if '<div class="vue-components-wrapper"' in main_content:
            main_content = main_content.split('<div class="vue-components-wrapper"')[0]
        else:
            main_content = main_content.split('@vite')[0]
            
        # Clean up any trailing closing tags from body/html or the appSistema div
        main_content = re.sub(r'</div>\s*</body>\s*</html>', '', main_content)
        main_content = main_content.strip()
        if main_content.endswith('</div>'):
             main_content = main_content[:-6].strip()
    else:
        main_content = ''

    new_content = f"""@extends('layouts.public')

@section('title', '{title}')

@section('styles')
<style>
{custom_styles}
</style>
@endsection

@section('content')
{main_content}
@endsection
"""
    with open('resources/views/' + file, 'w', encoding='utf-8') as f:
        f.write(new_content)
print('Done modifying 4 files.')
