import json
import os
import argparse
import sys

def load_data(file_path):
    if not os.path.exists(file_path):
        return None
    with open(file_path, 'r', encoding='utf-8') as f:
        return json.load(f)

def visualize_calendar(data, title="Results"):
    """Prints a clean, sorted table of calendar entries."""
    if not data:
        print(f"\nNo entries found matching your criteria.")
        return
    print(f"\n--- {title} ({len(data)} entries) ---")
    print(f"{'Date':<12} | {'Color':<9} | {'Entry Text'}")
    print("-" * 65)
    for date in sorted(data.keys()):
        entry = data[date]
        color = entry.get('color', 'N/A')
        text = entry.get('text', '(No Label)')
        print(f"{date:<12} | {color:<9} | {text}")
    print("-" * 65 + "\n")

def manage_calendar(args):
    data = load_data(args.file)
    if data is None:
        print(f"Error: {args.file} not found.")
        return

    # 1. Search Mode: Just show matches and exit
    if args.search:
        matches = {
            d: v for d, v in data.items() 
            if (not args.keyword or args.keyword.lower() in v.get('text', '').lower()) and 
               (not args.date or d == args.date) and
               (not args.clear_empty or not v.get('text', '').strip())
        }
        visualize_calendar(matches, "Search Results")
        return

    # 2. Visualization Mode: Show the whole archive
    if args.visualize:
        visualize_calendar(data, "Full Calendar Archive")
        return

    # 3. Modification Logic (Delete/Interactive)
    initial_count = len(data)
    final_data = data.copy()
    removed_count = 0

    for date in sorted(data.keys()):
        entry = data[date]
        text = entry.get('text', '')
        
        is_match = (args.date and date == args.date) or \
                   (args.keyword and args.keyword.lower() in text.lower()) or \
                   (args.clear_empty and not text.strip())

        if is_match:
            if args.interactive:
                choice = input(f"Remove? [{date}] '{text}': (y/N) ").lower()
                if choice == 'y':
                    del final_data[date]
                    removed_count += 1
            else:
                del final_data[date]
                removed_count += 1

    # Save changes
    with open(args.out, 'w', encoding='utf-8') as f:
        json.dump(final_data, f, indent=2)

    print(f"Success. Removed {removed_count} entries. Saved to {args.out}.")

if __name__ == "__main__":
    parser = argparse.ArgumentParser(
        description="Aligned Calendar Utility: Search, Visualize, and Clean your data.",
        epilog="""
Examples:
  View all entries:       python cal_tool.py archive.json -v
  Search for Lydia:       python cal_tool.py archive.json --search --keyword "Lydia"
  Interactive delete:     python cal_tool.py archive.json --keyword "Carl Work" -i
  Remove empty dates:     python cal_tool.py archive.json --clear-empty --out cleaned.json
        """,
        formatter_class=argparse.RawDescriptionHelpFormatter
    )
    parser.add_argument("file", help="The JSON export file")
    parser.add_argument("-v", "--visualize", action="store_true", help="View all entries in a table")
    parser.add_argument("-s", "--search", action="store_true", help="Search and list matches without deleting")
    parser.add_argument("-i", "--interactive", action="store_true", help="Confirm each deletion")
    parser.add_argument("--keyword", help="Filter by text keyword")
    parser.add_argument("--date", help="Filter by specific date (YYYY-MM-DD)")
    parser.add_argument("--clear-empty", action="store_true", help="Target entries with no text labels")
    parser.add_argument("--out", default="modified_calendar.json", help="Output file name")

    if len(sys.argv) == 1:
        parser.print_help()
        sys.exit(1)

    args = parser.parse_args()
    manage_calendar(args)
