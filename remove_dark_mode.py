import os
import re
from pathlib import Path

# Define the base directory
base_dir = r"c:\laragon\www\ecom-la\resources\views"

# List of files to process
files_to_process = [
    "welcome.blade.php",
    "livewire/settings/two-factor.blade.php",
    "livewire/settings/two-factor/recovery-codes.blade.php",
    "livewire/settings/profile.blade.php",
    "livewire/auth/verify-email.blade.php",
    "livewire/auth/register.blade.php",
    "livewire/auth/login.blade.php",
    "flux/navlist/group.blade.php",
    "dashboard.blade.php",
    "components/layouts/app/header.blade.php",
    "components/layouts/app/sidebar.blade.php",
    "components/layouts/auth/simple.blade.php",
    "components/layouts/auth/split.blade.php",
    "components/layouts/auth/card.blade.php",
    "components/input-otp.blade.php",
    "components/app-logo.blade.php"
]

# Pattern to match dark mode classes
dark_pattern = r'\s+dark:[^\s"\'>\]]+' 

files_updated = []

for file_path in files_to_process:
    full_path = os.path.join(base_dir, file_path)
    
    if os.path.exists(full_path):
        with open(full_path, 'r', encoding='utf-8') as f:
            content = f.read()
        
        # Remove dark mode classes
        new_content = re.sub(dark_pattern, '', content)
        
        if content != new_content:
            with open(full_path, 'w', encoding='utf-8') as f:
                f.write(new_content)
            files_updated.append(file_path)
            print(f"✓ Updated: {file_path}")
        else:
            print(f"- No changes: {file_path}")
    else:
        print(f"✗ Not found: {file_path}")

print(f"\n{len(files_updated)} files updated successfully!")
