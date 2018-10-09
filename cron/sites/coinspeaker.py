from .main import Main

class CCoinspeaker(Main):
    def __init__(self, link, posts, handbook):
        Main.__init__(self, link, posts, handbook)

        self.menu = ['Bitcoin', 'EOS']

        self.result = []

    def start(self):
        try:
            menu = self.get_menu('class', 'subNav')

            for page in menu:
                self.get_news(page['url'], page['title'])

            self.log.write("End: added {0} posts".format(len(self.result)))
        except RuntimeError as error:
            self.log.write("Error: {0}".format(error))

    def get_news(self, url, section):
        self.set_file(url)

        soup = self.soup()

        wrapper = soup.find('div', {'class': 'sectionContent'})

        try:
            blocks = wrapper.find_all('div', {'class': 'itemBlock'})
        except AttributeError:
            raise RuntimeError("structure of the news list has changed")

        for block in blocks:
            a = block.find('h3').find('a')

            url = self.check_url(a.get('href'))
            title = a.text.strip()
            replacements = (u'rd', u''), (u'nd', u''), (u'st', u''), (u'th', u'')
            date = self.multiple_replace(str(block.find('div', {'class': 'newsDate'}).text.strip()), *replacements)

            if self.check_date(date, False, "%B %d, %Y") is None:
                break

            if title in self.posts:
                continue

            try:
                post = self.get_post(url)

                if post:
                    handbook = self.check_handbook_post(title, post['content'])

                    if handbook:
                        self.result.append({
                            'url': url,
                            'title': title,
                            'date': date,
                            'section': section,
                            'text': post['content'],
                            'handbook': handbook
                        })

                        self.posts.append(title)

            except Warning as error:
                self.log.write("Error: {0}".format(error))

    def get_post(self, url):
        if url is None:
            return

        self.set_file(url)

        soup = self.soup()

        content = soup.find('article')

        try:
            content = content.find('div', {'class': 'entry-content'})

            if content is None:
                raise Warning("structure of the news post has changed. Post link: {0}".format(url))
        except AttributeError:
            raise Warning("structure of the news post has changed. Post link: {0}".format(url))

        text = []
        for div in content.find_all('div'):
            if not div is None:
                div.extract()

        for p in content.find_all('p'):
            script = p.script

            if not script is None:
                script.extract()

            text.append(self.clear(p.text))

        return {
            'content': '<br>'.join(text),
        }