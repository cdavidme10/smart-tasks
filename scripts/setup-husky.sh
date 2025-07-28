#!/bin/bash

echo "🧹 Cleaning up any manual Git hooks..."
rm -f .git/hooks/pre-commit

echo "📦 Installing Husky..."
npm install husky --save-dev

echo "🎯 Initializing Husky..."
npx husky-init
npm install

echo "✍️ Writing custom pre-commit hook..."
cat > .husky/pre-commit <<'EOF'
#!/bin/sh

. "$(dirname "$0")/_/husky.sh"

# Run composer ci inside Sail
vendor/bin/sail composer ci || exit 1

# Run OpenAPI validation inside Sail
vendor/bin/sail npm run openapi:validate || exit 1

echo "✅ All checks passed. Proceeding with commit!"
exit 0

EOF

echo "🔐 Setting executable permissions..."
chmod +x .husky/pre-commit

echo "🔧 Activating Husky..."
npm run prepare

echo "🎉 Husky setup complete!"
