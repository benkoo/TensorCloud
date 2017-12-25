package info.smartkit.elk.piwik.service.converter;

import info.smartkit.elk.piwik.domain.PiwikLogVisit;
import info.smartkit.elk.web.domain.User;
import info.smartkit.elk.piwik.request.PiwikLogVisitRequest;
import info.smartkit.elk.piwik.response.PiwikLogVisitResponse;
import info.smartkit.elk.web.request.UserResourceRequest;
import org.springframework.stereotype.Component;

import java.io.UnsupportedEncodingException;

@Component
public class PiwikLogVisitConverter {
    /**
     * Converts {@link PiwikLogVisit} to {@link PiwikLogVisitResponse}
     *
     * @param user {@link PiwikLogVisit}
     * @return {@link PiwikLogVisitResponse}
     */
    public PiwikLogVisitResponse convert(final PiwikLogVisit piwikLogVisit) {
        return new PiwikLogVisitResponse(piwikLogVisit.getIdvisit(),piwikLogVisit.getIdsite(), piwikLogVisit.getIdvisitor(), piwikLogVisit.getUser_id(), piwikLogVisit.getVisit_last_action_time(),piwikLogVisit.getLocation_ip());
    }

    /**
     * Converts {@link UserResourceRequest} to a domain {@link User}.
     *
     * @param request {@link UserResourceRequest}
     * @return {@link User}
     */
    public PiwikLogVisit convert(final PiwikLogVisitRequest request) throws UnsupportedEncodingException {
        final PiwikLogVisit user = new PiwikLogVisit();
        convertCommonFields(request, user);
        return user;
    }

    /**
     * Converts {@link UserResourceRequest} to a domain {@link User}.
     *
     * @param request {@link UserResourceRequest}
     * @return {@link User}
     */
    public PiwikLogVisit convert(final PiwikLogVisitRequest request, final String userId) {
        final PiwikLogVisit user = new PiwikLogVisit();
        user.setIdvisit(userId);
        convertCommonFields(request, user);
        return user;
    }

    private void convertCommonFields(final PiwikLogVisitRequest request, final PiwikLogVisit user) {
        user.setIdvisit(request.getIdvisit());
        user.setIdvisitor(request.getIdvisitor());
        user.setUser_id(request.getUser_id());
        user.setLocation_ip((request.getLocation_ip()));
        user.setVisit_last_action_time(request.getVisit_last_action_time());
    }
}
