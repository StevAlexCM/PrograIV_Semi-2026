import re
file = 'welcome.blade.php'
with open('resources/views/' + file, 'r', encoding='utf-8') as f:
    content = f.read()

# Extract Title
title_match = re.search(r'<title>(.*?)</title>', content)
title = title_match.group(1) if title_match else 'HidroVida'

# Extract Custom Styles
styles_match = re.search(r'/\*\s*Hero Section\s*\*\/([\s\S]*?)</style>', content)
if styles_match:
    custom_styles = '/* Hero Section */\n' + styles_match.group(1).strip()
else:
    custom_styles = ''

# Extract main content (everything between <main> and </main>)
main_match = re.search(r'<main[^>]*>([\s\S]*?)</main>', content)
if main_match:
    main_content = main_match.group(1).strip()
    
    # Remove vue wrapper if it exists (it's now in the layout)
    if '<div class="vue-components-wrapper"' in main_content:
        main_content = main_content.split('<div class="vue-components-wrapper"')[0].strip()
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
print('Done welcome.blade.php')
