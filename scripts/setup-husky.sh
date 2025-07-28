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

# Wait for Sail to be ready
for i in {1..10}; do
  vendor/bin/sail php -v && break
  echo "⏳ Waiting for Sail to start..."
  sleep 2
done

echo "🚀 Running composer ci..."
vendor/bin/sail composer ci || exit 1

echo "🎯 Running lint-staged..."
vendor/bin/sail npx lint-staged || exit 1

echo "📚 Validating OpenAPI spec..."
vendor/bin/sail npm run openapi:validate || exit 1

echo "✅ All checks passed! Proceeding with commit!"
exit 0

EOF

echo "🔐 Setting executable permissions..."
chmod +x .husky/pre-commit

echo "🔧 Activating Husky..."
npm run prepare

echo "🎉 Husky setup complete!"
