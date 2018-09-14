# Publish new release. Usage:
#   make tag VERSION=(major|minor|patch)
# You need to install https://github.com/flazz/semver/ before
tag:
	@semver inc $(VERSION)
	@echo "New release: `semver tag`"
	@echo Releasing sources
	@sed -i -r "s/(v[0-9]+\.[0-9]+\.[0-9]+)/`semver tag`/g" \
		Resources/doc/index.md

# Tag git with last release
release:
	@git add .
	@git commit -m "releasing `semver tag`"
	@(git tag --delete `semver tag`) || true
	@(git push --delete origin `semver tag`) || true
	@git tag `semver tag`
	@git push -u origin 2.x
	@git push origin `semver tag`
