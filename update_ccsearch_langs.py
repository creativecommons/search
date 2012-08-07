#!/usr/bin/python

"""
Determine translation status of a PO as a percentage, and if 100% write out an
MO file. Used for CC Search. This is an adaptation of this script:
http://code.creativecommons.org/viewgit/i18n.git/tree/cc/i18n/tools/transstats.py
"""

import os
import subprocess
import optparse
from babel.messages.pofile import read_po

DEFAULT_INPUT_DIR = '/var/www/search.creativecommons.org/www/locale/po' 

def gen_statistics(input_dir):
    """
    - input_dir: The directory of languages we'll iterate through
    """

    input_dir = os.path.abspath(input_dir)
    lang_dirs = os.listdir(input_dir)

    # iterate through all the languages
    for lang in lang_dirs:

        po_file = os.path.join(input_dir, lang, 'LC_MESSAGES/ccsearch.po')
        mo_file = os.path.join(input_dir, lang, 'LC_MESSAGES/ccsearch.mo')

        if not os.path.exists(po_file):
            continue

        # load .po file
        po_data = read_po(file(po_file, 'r'))

        fuzzies = 0
        translated = 0

        # generate statistics
        for message in po_data:
            if message.id and message.string:
                if message.fuzzy:
                    fuzzies += 1
                else:
                    translated += 1

        percent_trans = int((float(translated) / len(po_data)) * 100)

	# if the translation is 100% complete then write out an MO file, which
	# will automatically cause it to display in CC Search, else remove any
	# existing PO, which will remove it from CC Search
	if percent_trans == 100:
            subprocess.call(['msgfmt', '-o', mo_file, po_file])
        else:
            if os.path.exists(mo_file):
                subprocess.call(['rm', '-f', mo_file])


def cli():
    """
    Command line interface
    """
    parser = optparse.OptionParser()

    parser.add_option(
        '-i', '--input_dir', dest='input_dir',
        help='Directory to search for .po files to generate statistics on.',
        default=DEFAULT_INPUT_DIR)

    options, args = parser.parse_args()

    gen_statistics(options.input_dir)


if __name__ == '__main__':
    cli()
