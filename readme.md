*Petition Platform*

This platform was put together at the behest of both DSG and the Graduate Student Council. Its need has become apparent as student activism has increased and the desire for a simplified interface to voice opinions to administration has developed. The Petition Platform has several goals, outlined below:

 - To allow students to create petitions in a consistent way, facilitating the voicing of powerful opinions
 - To give administration a streamlined interface to answer official requests by the general student body (<3 Larry Moneta)
 - That's basically it?
 
**Architecture**

The Design of the Petition platform follows its goals. Modular design should allow for future expansion and integration, as well as proper separation of labor between back-end dev, data management, front-end dev, styling, etc. For this reason, the back-end utilizes a simple php core to provide a data-only API, with a static front-end that pulls and renders this data. The template engine Handlebars will be executing the rendering of petition templates, etc. Authentication, in version 1 at least, will be accomplished with shibboleth, which can guarantee that a netid has logged in and extract the netid using Duke's SSO system.

***Data Structures***

Petitions have the following attributes:

    -id: A unique identifier for the petition
    -name: A short name to identify and explain the petition
    -content: The full petition text
    -tags: a JSON array of strings that can be used for searching and classifying the petition
    -category: A single string (chosen from a set list of categories) used to group petitions
    -voters: A list of netids that have voted for the petition in question
    -count: A full count of voters (necessary to display the vote count without exposing all of the voters' identities to the client)

Users also have attributes that are stored:

    -netid: unique netid
    -lastvote: unix time (millis) of the last vote made by the user
    -remainingVotes: number of votes remaining for the day for the user
    
***Interface***

The system is designed to allow users to vote a set number of times per day (probably 3). Votes can be counted multiple times for the same petition. This is represented in the petition structure itself as multiple additions of the same netid to the 'votes' attribute. Each POST to the voting 

***Directory Structure***

The structure below is an explanation of the directory structure of the repo: