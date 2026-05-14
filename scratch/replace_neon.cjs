const fs = require('fs');
const path = require('path');

const directory = 'c:/FSR/sipedis/resources/views';

const replacements = {
    // Remove neon accents
    'text-emerald-400': 'text-theme-successText',
    'bg-emerald-400': 'bg-theme-success',
    'border-emerald-400': 'border-theme-success',
    'text-blue-400': 'text-theme-infoText',
    'bg-blue-400': 'bg-theme-info',
    'text-red-400': 'text-theme-errorText',
    'bg-red-400': 'bg-theme-error',
    'text-amber-400': 'text-theme-warningText',
    'bg-amber-400': 'bg-theme-warning',
    
    // Clean up residual tailwind colors
    'bg-emerald-900/20': 'bg-theme-success/20',
    'bg-emerald-900/40': 'bg-theme-success/40',
    'border-emerald-800': 'border-theme-success',
    'bg-red-900/20': 'bg-theme-error/20',
    'bg-red-900/40': 'bg-theme-error/40',
    'border-red-800': 'border-theme-error',
    
    // Convert remaining specific bright colors in the app
    'text-white': 'text-theme-text1',
    'hover:text-white': 'hover:text-theme-text1',
    'bg-white': 'bg-theme-card',
    'border-slate-300': 'border-theme-border',
    'text-slate-700': 'text-theme-text1',
    'text-emerald-600': 'text-theme-successText',
    'bg-emerald-600': 'bg-theme-success',
    'bg-emerald-100': 'bg-theme-success/30',
};

function processDirectory(dir) {
    const files = fs.readdirSync(dir);
    
    for (const file of files) {
        const fullPath = path.join(dir, file);
        const stat = fs.statSync(fullPath);
        
        if (stat.isDirectory()) {
            processDirectory(fullPath);
        } else if (fullPath.endsWith('.blade.php')) {
            let content = fs.readFileSync(fullPath, 'utf8');
            let modified = false;
            
            for (const [key, value] of Object.entries(replacements)) {
                // simple replace all
                if (content.includes(key)) {
                    content = content.split(key).join(value);
                    modified = true;
                }
            }
            
            if (modified) {
                fs.writeFileSync(fullPath, content, 'utf8');
                console.log(`Updated: ${fullPath}`);
            }
        }
    }
}

processDirectory(directory);
console.log('Done mapping UI colors.');
