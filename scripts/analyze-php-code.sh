#!/bin/bash
# PHP Code Analyzer Script
# Analyzes PHP code against best practices from this skill

set -e

# Default values
DIRECTORY="."
OUTPUT_FORMAT="text"
VERBOSE=false

# Parse command line arguments
while [[ $# -gt 0 ]]; do
  case $1 in
    -d|--directory)
      DIRECTORY="$2"
      shift 2
      ;;
    -f|--format)
      OUTPUT_FORMAT="$2"
      shift 2
      ;;
    -v|--verbose)
      VERBOSE=true
      shift
      ;;
    *)
      echo "Unknown option: $1"
      exit 1
      ;;
  esac
done

# Check if PHP is available
if ! command -v php &> /dev/null; then
  echo "Error: PHP is not installed or not in PATH"
  exit 1
fi

echo "PHP Best Practices Analysis"
echo "==========================="
echo "Directory: $DIRECTORY"
echo "Format: $OUTPUT_FORMAT"
echo ""

# Count PHP files
PHP_FILES=$(find "$DIRECTORY" -name "*.php" -type f | wc -l)
echo "Found $PHP_FILES PHP files"

if [ "$PHP_FILES" -eq 0 ]; then
  echo "No PHP files found in $DIRECTORY"
  exit 0
fi

# Run PHP lint check
echo ""
echo "1. PHP Syntax Check"
echo "------------------"
BAD_SYNTAX=0
while IFS= read -r file; do
  if php -l "$file" > /dev/null 2>&1; then
    if [ "$VERBOSE" = true ]; then
      echo "✓ $file"
    fi
  else
    echo "✗ $file has syntax errors"
    BAD_SYNTAX=$((BAD_SYNTAX + 1))
  fi
done < <(find "$DIRECTORY" -name "*.php" -type f)

# Check for common issues
echo ""
echo "2. Common Best Practices Violations"
echo "----------------------------------"

# Check for magic values
echo "Checking for magic values..."
MAGIC_VALUES=$(grep -r "['\"]pending['\"]\|['\"]active['\"]\|['\"]inactive['\"]" "$DIRECTORY" --include="*.php" | grep -v "const\|define" | wc -l)
echo "Found $MAGIC_VALUES potential magic string values"

# Check for type declarations
echo "Checking for missing type declarations..."
NO_TYPE_DECL=$(grep -r "function\s\+\w\+\s*(" "$DIRECTORY" --include="*.php" | grep -v "function\s\+\w\+\s*(.*):" | wc -l)
echo "Found $NO_TYPE_DECL functions without return type declarations"

# Check for else statements
echo "Checking for else statements..."
ELSE_STATEMENTS=$(grep -r "\belse\b" "$DIRECTORY" --include="*.php" | wc -l)
echo "Found $ELSE_STATEMENTS else statements (consider using guard clauses)"

# Check for deep nesting
echo "Checking for deep nesting..."
DEEP_NESTING=$(find "$DIRECTORY" -name "*.php" -type f -exec grep -l "if.*{.*if.*{.*if" {} \; | wc -l)
echo "Found $DEEP_NESTING files with potentially deep nesting"

# Summary
echo ""
echo "Summary"
echo "======="
echo "Total PHP files: $PHP_FILES"
echo "Syntax errors: $BAD_SYNTAX"
echo "Magic values: $MAGIC_VALUES"
echo "Missing return types: $NO_TYPE_DECL"
echo "Else statements: $ELSE_STATEMENTS"
echo "Deep nesting files: $DEEP_NESTING"

if [ "$BAD_SYNTAX" -gt 0 ]; then
  echo ""
  echo "⚠️  Found $BAD_SYNTAX files with syntax errors. Fix these first."
  exit 1
fi

echo ""
echo "✅ Analysis complete. Review the violations above against PHP best practices."