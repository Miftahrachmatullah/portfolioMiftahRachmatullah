import re
import os

with open('index_backup_utf8.html', 'r', encoding='utf-8') as f:
    html = f.read()

# Make directories
os.makedirs('resources/views/layouts', exist_ok=True)
os.makedirs('resources/views/components', exist_ok=True)
os.makedirs('resources/views/pages', exist_ok=True)
os.makedirs('resources/views/auth', exist_ok=True)
os.makedirs('resources/views/admin', exist_ok=True)

# Extract layout top (up to body tag and including body opening)
layout_top = html[:html.find('<nav class=')].strip()

# Replace the title with yielding title, and add vite
layout_top = layout_top.replace(
    '<title>Mochamad Miftah Rachmatullah - Portfolio</title>',
    '<title>@yield("title", "Mochamad Miftah Rachmatullah - Portfolio")</title>\n    @vite(["resources/css/app.css", "resources/js/app.js"])'
)

# Extract navbar
nav_start = html.find('<nav class=')
nav_end = html.find('</nav>') + 6
navbar = html[nav_start:nav_end]

# Modify Navbar to have a single Login button
# Remove "VIEW CV" and "PORTFOLIO" buttons, replace with Login
navbar = re.sub(
    r'<div class="hidden md:flex items-center gap-3">.*?</div>',
    '<div class="hidden md:flex items-center gap-3">\n            <a href="/login" class="nb-btn nb-btn-dark px-4 py-2 text-sm">LOGIN</a>\n          </div>',
    navbar,
    flags=re.DOTALL
)
navbar = re.sub(
    r'<div class="flex gap-3 pt-2">.*?</div>',
    '<div class="flex gap-3 pt-2">\n            <a href="/login" class="nb-btn nb-btn-dark px-4 py-2 text-sm">LOGIN</a>\n          </div>',
    navbar,
    flags=re.DOTALL
)

# Write navbar component
with open('resources/views/components/navbar.blade.php', 'w', encoding='utf-8') as f:
    f.write(navbar)

# Extract main content (between </nav> and <footer)
main_start = nav_end
main_end = html.find('<footer')
main_content = html[main_start:main_end].strip()

# Write home page
home_page = "@extends('layouts.app')\n\n@section('content')\n" + main_content + "\n@endsection\n"
with open('resources/views/pages/home.blade.php', 'w', encoding='utf-8') as f:
    f.write(home_page)

# Extract footer
footer_start = main_end
footer_end = html.find('</footer>') + 9
footer = html[footer_start:footer_end]

# Write footer component
with open('resources/views/components/footer.blade.php', 'w', encoding='utf-8') as f:
    f.write(footer)

# Extract layout bottom (from after footer to end)
layout_bottom = html[footer_end:].strip()

# Construct app.blade.php
app_layout = f"""{layout_top}
    @include('components.navbar')

    <main>
        @yield('content')
    </main>

    @include('components.footer')
{layout_bottom}"""

with open('resources/views/layouts/app.blade.php', 'w', encoding='utf-8') as f:
    f.write(app_layout)

print("Split completed.")
