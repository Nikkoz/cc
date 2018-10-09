from helpers import File, Db, Log
from union import Union
from sites import *

class Scraping(Union):
    def __init__(self):
        self.type = 'sites'

        self.db = Db()
        self.file = File()
        self.log = Log(self.type)

        self.news = []

    #list of sites from db
    def site_list(self):
        return self.db.get_sites()

    # get all posts
    def posts_list(self):
        result = self.db.get_posts('post', self.day_ago())
        posts = []

        for post in result:
            posts.append(post[0])

        return posts

    def handbook_list(self):
        handbooks = {}
        for handbook in self.db.get_handbook():
            handbooks[handbook[0]] = {
                'title': handbook[1],
                'check': handbook[2]
            }

        return handbooks

    def start(self):
        # check import is ready
        if not self.start_import():
            return False

        self.posts = self.posts_list()
        self.handbook = self.handbook_list()

        #print(len(self.posts))

        if self.handbook:
            for site in self.site_list():
                if site[3] > 0:
                    self.scrap(site)
                else:
                    self.log.write("resourse {0} is desabled".format(site[1]))

            #save news to db
            print(len(self.news))
            #print(self.posts)

        self.finish_import()


    def scrap(self, site):
        self.file.set_file(site[1])

        resourse = self.switch(site)
        resourse.start()

        self.news = self.merge(self.news, resourse.get_posts())
        self.posts = resourse.get_titles()

    def switch(self, site):
        x = site[2]

        self.log.write("---\n{0} start at {1}".format(site[1], self.get_day()));

        if x == 'thebitcoinnews':
            return CThebitcoinnews(site[1], self.posts, self.handbook)
        elif x == 'coinjournal':
            return CCoinjournal(site[1], self.posts, self.handbook)
        elif x == 'coindesk':
            return CCoindesk(site[1], self.posts, self.handbook)
        elif x == 'bitcoin':
            return CBitcoin(site[1], self.posts, self.handbook)
        elif x == 'cointelegraph':
            return CCointelegraph(site[1], self.posts, self.handbook)
        elif x == 'bitcoinmagazine':
            return CBitcoinmagazine(site[1], self.posts, self.handbook)
        elif x == 'newsbtc':
            return CNewsbtc(site[1], self.posts, self.handbook)
        elif x == 'forklog':
            return CForklog(site[1], self.posts, self.handbook)
        elif x == 'coinspeaker':
            return CCoinspeaker(site[1], self.posts, self.handbook)
        elif x == 'bitcoinist':
            return CBitcoinist(site[1], self.posts, self.handbook)
        elif x == 'bitcoinertoday':
            return CBitcoinertoday(site[1], self.posts, self.handbook)
        elif x == 'coindoo':
            return CCoindoo(site[1], self.posts, self.handbook)
        elif x == 'trustnodes':
            return CTrustnodes(site[1], self.posts, self.handbook)
        elif x == 'btcmanager':
            return CBtcmanager(site[1], self.posts, self.handbook)
        elif x == 'usethebitcoin':
            return CUsethebitcoin(site[1], self.posts, self.handbook)
        elif x == 'investinblockchain':
            return CInvestinblockchain(site[1], self.posts, self.handbook)
        elif x == 'ethereumworldnews':
            return CEthereumworldnews(site[1], self.posts, self.handbook)
        elif x == 'coinstaker':
            return CCoinstaker(site[1], self.posts, self.handbook)
        elif x == 'livebitcoinnews':
            return CLivebitcoinnews(site[1], self.posts, self.handbook)
        elif x == 'coinsnewbium':
            return CCoinsnewbium(site[1], self.posts, self.handbook)
        elif x == 'ccn':
            return CCcn(site[1], self.posts, self.handbook)
        elif x == 'themerkle':
            return CThemerkle(site[1], self.posts, self.handbook)
        elif x == 'ethnews':
            return CEthnews(site[1], self.posts, self.handbook)
        elif x == 'zycrypto':
            return CZycrypto(site[1], self.posts, self.handbook)
        elif x == 'profitconfidential':
            return CProfitconfidential(site[1], self.posts, self.handbook)
        elif x == 'cryptoanswers':
            return CCryptoanswers(site[1], self.posts, self.handbook)
        elif x == 'bloomberg':
            return CBloomberg(site[1], self.posts, self.handbook)

        return None



#start
scraping = Scraping();
scraping.start();