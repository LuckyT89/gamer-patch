"""
Functions for pulling overwatch patch notes and writing to HTML files.
"""

import requests
from lxml import html


def getContent(link):
    """Helper function for returning the html content of a link."""
    page = requests.get(link)
    return(html.fromstring(page.content))


def formatDate(dat):
    """Helper function to fix the date format used by overwatch."""
    x = ['{:02d}'.format(int(x)) for x in dat.replace(".", "/").split("/")]
    return("%s-%s-%s" % (x[2], x[0], x[1]))


def getDatesAndLinks(link):
    """
    Helper function to get dates and links of patch notes from a page
    
    Parameters:
    ----------
    link (string): A link to the page for which to extract the patch
        notes dates and links.
    
    Returns:
    -------
    A list of tuples, where the first element is the date of the patch
    notes release, and the second element is the link to those notes.
    """
    platform = link.split("/")[-1]
    cont = getContent(link)
    dates = cont.xpath(
        "//div[@class='PatchNotesSideNav']//p[@class='u-float-right']/text()"
    )
    dates = map(formatDate, dates)
    links = [
        link + x
        for x in cont.xpath(
            "//div[@class='PatchNotesSideNav']//a[@class='u-float-left']/@href"
        )
    ]
    return(zip(dates, links))
    

def getRecentLinks(platform="pc", n=1):
    """
    Gets the most recent 'n' patch note links.
    
    If n is greater than 5 (the number of links posted on the primary URL),
    this function cycles through the pages of past links. Links are returned
    in order of date descending.
    
    Parameters:
    ----------
    platform (string): The platform for which to pull patch note links.
        One of 'pc', 'ps4', 'xb1', or 'nintendo-switch'.
    n (int): The number of links to return. When set to 1, only the
        most recent patch notes link is returned.
    
    Returns:
    -------
    A list of tuples, where the first element is the date of the patch
    notes release, and the second element is the link to those notes.
    """
    # If n < 5, we can just use the base URL and get the dates and links
    if n < 5:
        output = getDatesAndLinks(
            "https://playoverwatch.com/en-us/news/patch-notes/" + platform
        )
        return(output[0:0 + n])
    # Otherwise, we need to get all of the pages of notes and cycle
    #   through past pages
    cont = getContent(
        "https://playoverwatch.com/en-us/news/patch-notes/" + platform
    )
    pages = cont.xpath("//div[@class='patch-notes-pagination']//a/text()")
    # Right now I'm cycling through all of the pages - I could introduce
    #   some logic to only cycle through enough pages to get 'n' links
    #   back
    output = []
    for page in pages:
        output = output + getDatesAndLinks(
            "https://playoverwatch.com/en-us/news/patch-notes/" +
            platform + "?page=" + page
        )
    return(output[0:0 + n])


def getPatchNotes(link):
    """
    Given a link to the patch notes, gets the HTML content of the notes.
    
    The content is returned as an HTML string.
    
    Parameters:
    ----------
    link (string): A link to the patch notes.
    
    Returns:
    -------
    A string containing the patch notes content in HTML format.
    """
    notes = getContent(link)
    tag = link.split("#")[-1]
    body = notes.xpath(
        "//div[@class='patch-notes-patch' and @id='%s']" % tag
    )[0]
    content = "".join(map(html.tostring, body.xpath("./*")))
    # There is some boilerplate at the top of these updates - so
    #   find the end of the boilerplate and return starting there
    start = content.find("forum.</p>")
    if start:
        return(content[start + 10:])
    return(content)


def writePatchNotes(notes, fileName):
    """Helper function to write the content of the notes to a file"""
    with(open(fileName, "w")) as fil:
        fil.write(notes)
        fil.close()


def writeRecentPatchNotes(platform="pc", n=1):
    """
    Writes the content of the recent patch notes to file(s).
    
    Parameters:
    ----------
    platform (string): The platform for which to write patch notes.
        One of 'pc', 'ps4', 'xb1', or 'nintendo-switch'.
    n (int): The number of links to return. When set to 1, only the
        most recent patch notes link is returned.
    """
    links = getRecentLinks(platform=platform, n=n)
    for i, x in enumerate(links):
        notes = getPatchNotes(x[1])
        writePatchNotes(
            notes=notes,
            fileName="updates/overwatch/%s.html" % x[0]
        )
