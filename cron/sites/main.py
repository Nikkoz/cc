#!/usr/bin/env python2
#encoding: UTF-8

from helpers import File, Log
from bs4 import BeautifulSoup
from datetime import datetime, timedelta

import time
import re

class Main():
    def __init__(self, link, posts, handbook):
        self.file = File()
        self.log = Log('sites')

        self.link = link
        self.posts = posts
        self.handbook = handbook

    #def posts(self):
    #    return self.posts

    def read_file(self):
        with self.file.read('page','html') as input_file:
            text = input_file.read()

        return text

    '''
    type - type of tag(id or class)
    value - value of tag
    '''
    def get_menu(self, type, value, inner = '', span = False):
        soup = self.soup()

        if inner != '':
            links = soup.find(inner, {type: value}).find('ul')
        else:
            links = soup.find('ul', {type: value})

        if not links:
            raise RuntimeError("structure of the site menu has changed")

        pages = []
        titles = []

        for item in links.find_all('a'):
            title = self.clear_title(item, span)

            if title in self.menu and not title in titles:
                titles.append(title)

                pages.append({
                    'title': title,
                    'url': self.check_url(item.get('href'))
                })

        return pages


    def set_file(self, url):
        self.file.set_file(url, 'sites')

    def soup(self):
        text = self.read_file()

        return BeautifulSoup(text, 'html.parser')

    def check_date(self, date, is_timestump = False, format = None):
        if format is None:
            date = date[:19]
            format = "%Y-%m-%dT%H:%M:%S"

        try:
            if not is_timestump:
                date = time.mktime(datetime.strptime(date, format).timetuple())

            day_ago = datetime.today() - timedelta(days=1)

            if(float(date) < day_ago.timestamp()):
                return None
        except ValueError:
            raise RuntimeError("structure date has changed")

        return date

    def get_posts(self):
        return self.result

    def get_titles(self):
        return self.posts

    def clear(self, text):
        try:
            myre = re.compile(u"[\U0001F300-\U0001F64F\U0001F680-\U0001F6FF\u2600-\u26FF\u2700-\u27BF]+", re.UNICODE)
        except re.error:
            myre = re.compile(u"(\ud83c[\udf00-\udfff]|\ud83d[\udc00-\ude4f\ude80-\udeff]|[\u2600-\u26FF\u2700-\u27BF])+", re.UNICODE)

        return myre.sub(r'', text.replace("\xa0", " ")).strip()

    def change_date(self, date, format = "%b %d, %Y"):
        number, type, ago = date.split(' ')

        if type == 'HOURS' or type == 'hours':
            date = datetime.now() - timedelta(hours=int(number))
        elif type == 'MINUTES' or type == 'minutes' or type == 'mins':
            date = datetime.now() - timedelta(minutes=int(number))

        return date.strftime(format)

    def clear_title(self, point, clear):
        spans = point.find_all('span')

        if spans and not clear:
            for span in spans:
                span.extract()

        return point.text.strip()

    def check_url(self, url):
        return self.link + url.replace(self.link, '').lstrip('/')

    def check_handbook_post(self, title, text):
        check = []

        for h in self.handbook:
            if self.handbook[h]['check'] == 0:
                pattern = re.compile('(^|\W)' + self.handbook[h]['title'] + '(\W|$)', re.IGNORECASE)
            else:
                pattern = re.compile('(^|\W)' + self.handbook[h]['title'] + '(\W|$)')

            match_title = re.search(pattern, title)
            match_text = re.search(pattern, text)

            if not match_text is None or not match_title is None:
                check.append(h)

        return check

    def multiple_replacer(self, *key_values):
        replace_dict = dict(key_values)
        replacement_function = lambda match: replace_dict[match.group(0)]
        pattern = re.compile("|".join([re.escape(k) for k, v in key_values]), re.M)
        return lambda string: pattern.sub(replacement_function, string)

    def multiple_replace(self, string, *key_values):
        return self.multiple_replacer(*key_values)(string)