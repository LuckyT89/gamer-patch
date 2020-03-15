"""
Script for pulling overwatch patch notes and writing to HTML files.

The output is written to updates/overwatch/<date>.html in a format
consistent with pre-existing files.

This is designed for use with python v2.7.

Parameters:
----------
platform (string): The platform for which to write patch note links.
    One of 'pc', 'ps4', 'xb1', or 'nintendo-switch'. Defaults to 'pc'.
n (int): The number of historical patch notes to write. When set to 1,
    only the most recent patch notes are written. Defaults to 1.

Usage:
-----
# Assumes that the script is being run from the 'root' directory
#   (e.g. gamer-patch/gamerpatchV4.1)
python py/main.py <platform> <n>

Examples:
--------

# Write only the most recent PC patch notes (using defaults)
python py/main.py

# Write 20 historical PC patch notes
python py/main.py pc 20

# Write 12 historical PS4 patch notes
python py/main.py ps4 12
"""

from gamerpatch.overwatch import writeRecentPatchNotes
import sys

if __name__ == "__main__":
    platform = "pc"
    n = 1
    if len(sys.argv) > 1:
        platform = sys.argv[1]
        platforms = ['pc', 'xb1', 'ps4', 'nintendo-switch']
        if platform not in platforms:
            msg = "Platform must be one of '%s'" % "', '".join(platforms)
            raise ValueError(msg)
    if len(sys.argv) > 2:
        n = int(sys.argv[2])
    writeRecentPatchNotes(platform=platform, n=n)
